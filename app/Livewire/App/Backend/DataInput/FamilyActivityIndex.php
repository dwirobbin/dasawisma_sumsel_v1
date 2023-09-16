<?php

namespace App\Livewire\App\Backend\DataInput;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\FamilyActivity;
use Illuminate\Database\Eloquent\Builder;

class FamilyActivityIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 5;

    #[Url()]
    public string $search = '';

    protected $listeners = ['family-deleted-success' => '$refresh'];

    public function placeholder()
    {
        return view('placeholder');
    }

    public function render()
    {
        $data = FamilyActivity::selectRaw("
                family_activities.id,
                IF(dasawismas.name IS NULL, 'Belum di set', dasawismas.name) AS dasawisma_name,
                IF(families.dasawisma_id IS NULL, 'Belum di set', CONCAT_WS(', ', provinces.name, regencies.name, districts.name, villages.name)) AS area,
                families.kk_head, families.kk_number,
                IF(family_activities.up2k_activity IS NULL, 'Tidak Ada', family_activities.up2k_activity) as up2k_activity,
                IF(family_activities.env_health_activity IS NULL, 'Tidak Ada', family_activities.env_health_activity) as env_health_activity
            ")
            ->leftJoin('families', 'family_activities.family_id', '=', 'families.id')
            ->leftJoin('dasawismas', 'families.dasawisma_id', '=', 'dasawismas.id')
            ->leftJoin('provinces', 'dasawismas.province_id', '=', 'provinces.id')
            ->leftJoin('regencies', 'dasawismas.regency_id', '=', 'regencies.id')
            ->leftJoin('districts', 'dasawismas.district_id', '=', 'districts.id')
            ->leftJoin('villages', 'dasawismas.village_id', '=', 'villages.id')
            ->when($this->search != '',  function (Builder $query) {
                $query->where('dasawismas.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('provinces.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('regencies.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('districts.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('villages.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('families.kk_head', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_activities.up2k_activity', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_activities.env_health_activity', 'LIKE', "%{$this->search}%");
            })
            ->orderBy('family_activities.id', 'DESC')
            ->paginate($this->perPage)->onEachSide(1);

        return view('livewire.app.backend.data-input.family-activity-index', [
            'family_activities' => $data,
        ]);
    }
}
