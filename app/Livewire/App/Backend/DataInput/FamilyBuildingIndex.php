<?php

namespace App\Livewire\App\Backend\DataInput;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\FamilyBuilding;
use Illuminate\Database\Eloquent\Builder;

class FamilyBuildingIndex extends Component
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
        $data = FamilyBuilding::selectRaw("
                family_buildings.id,
                IF(dasawismas.name IS NULL, 'Belum di set', dasawismas.name) AS dasawisma_name,
                families.kk_head,
                families.kk_number, family_buildings.staple_food,
                IF(families.dasawisma_id IS NULL, 'Belum di set', CONCAT_WS(', ', provinces.name, regencies.name, districts.name, villages.name)) AS area,
                (CASE WHEN (family_buildings.have_toilet = 1) THEN 'Ya' ELSE 'Tidak' END) as have_toilet,
                family_buildings.water_src,
                (CASE WHEN (family_buildings.have_landfill = 1) THEN 'Ya' ELSE 'Tidak' END) as have_landfill,
                (CASE WHEN (family_buildings.have_sewerage = 1) THEN 'Ya' ELSE 'Tidak' END) as have_sewerage,
                (CASE WHEN (family_buildings.pasting_p4k_sticker = 1) THEN 'Ya' ELSE 'Tidak' END) as pasting_p4k_sticker,
                family_buildings.house_criteria
            ")
            ->leftJoin('families', 'family_buildings.family_id', '=', 'families.id')
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
                    ->orWhere('family_buildings.staple_food', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_buildings.water_src', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_buildings.house_criteria', 'LIKE', "%{$this->search}%");
            })
            ->orderBy('families.id', 'DESC')
            ->paginate($this->perPage)->onEachSide(1);

        return view('livewire.app.backend.data-input.family-building-index', [
            'family_buildings' => $data,
        ]);
    }
}
