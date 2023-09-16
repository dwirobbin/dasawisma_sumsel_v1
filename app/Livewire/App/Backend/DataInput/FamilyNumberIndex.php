<?php

namespace App\Livewire\App\Backend\DataInput;

use Livewire\Component;
use App\Models\FamilyNumber;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class FamilyNumberIndex extends Component
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
        $data = FamilyNumber::selectRaw("
                family_numbers.id,
                IF(dasawismas.name IS NULL, 'Belum di set', dasawismas.name) AS dasawisma_name,
                families.kk_head, families.kk_number,
                IF(families.dasawisma_id IS NULL, 'Belum di set', CONCAT_WS(', ', provinces.name, regencies.name, districts.name, villages.name)) AS area,
                family_numbers.toddlers_number, family_numbers.pus_number, family_numbers.wus_number,
                family_numbers.blind_people_number, family_numbers.pregnant_women_number,
                family_numbers.breastfeeding_mother_number, family_numbers.elderly_number
            ")
            ->leftJoin('families', 'family_numbers.family_id', '=', 'families.id')
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
                    ->orWhere('family_numbers.toddlers_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_numbers.pus_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_numbers.wus_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_numbers.blind_people_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_numbers.pregnant_women_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_numbers.breastfeeding_mother_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_numbers.elderly_number', 'LIKE', "%{$this->search}%");
            })
            ->orderBy('families.id', 'DESC')
            ->paginate($this->perPage)->onEachSide(1);

        return view('livewire.app.backend.data-input.family-number-index', [
            'family_numbers' => $data,
        ]);
    }
}
