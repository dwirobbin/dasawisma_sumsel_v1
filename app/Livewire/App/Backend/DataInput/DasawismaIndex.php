<?php

namespace App\Livewire\App\Backend\DataInput;

use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Province;
use App\Models\Dasawisma;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class DasawismaIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 5;

    #[Url(history: true)]
    public string $search = '';

    public $provinces = [], $regencies = [], $districts = [], $villages = [];
    public string $provinceId = '', $regencyId = '', $districtId = '', $villageId = '';

    public function mount()
    {
        $this->provinces = Province::get(['id', 'name']);
    }

    public function placeholder()
    {
        return view('placeholder');
    }

    public function updatingSearch()
    {
        $this->resetExcept('provinces');
        $this->resetPage();
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function updatedProvinceId($provinceId)
    {
        if ($this->provinceId !== '') {
            $this->regencies    = Regency::select(['id', 'name'])
                ->where('province_id', '=', $provinceId)
                ->orderBy('name')
                ->get();

            $this->reset('districtId', 'villageId', 'search');
        } else {
            $this->resetExcept('provinces');
        }
    }

    public function updatedRegencyId($regencyId)
    {
        if ($this->regencyId !== '') {
            $this->districts = District::select(['id', 'name'])
                ->where('regency_id', '=', $regencyId)
                ->orderBy('name')
                ->get();

            $this->reset('villageId', 'search');
        } else {
            $this->resetExcept('provinces', 'provinceId', 'regencies');
        }
    }

    public function updatedDistrictId($districtId)
    {
        if ($this->districtId !== '') {
            $this->villages = Village::select(['id', 'name'])
                ->where('district_id', '=', $districtId)
                ->orderBy('name')
                ->get();
        } else {
            $this->resetExcept('provinces', 'regencies', 'provinceId', 'regencyId', 'districts');
        }
    }

    public function render()
    {
        $data = Dasawisma::selectRaw("
            dasawismas.id, dasawismas.name, dasawismas.slug, dasawismas.rt, dasawismas.rw,
            dasawismas.province_id, dasawismas.regency_id, dasawismas.district_id, dasawismas.village_id,
            CONCAT_WS(', ', provinces.name, regencies.name, districts.name, villages.name) AS area
        ")
            ->leftJoin('provinces', 'dasawismas.province_id', '=', 'provinces.id')
            ->leftJoin('regencies', 'dasawismas.regency_id', '=', 'regencies.id')
            ->leftJoin('districts', 'dasawismas.district_id', '=', 'districts.id')
            ->leftJoin('villages', 'dasawismas.village_id', '=', 'villages.id')
            ->when($this->search != '', function (Builder $query) {
                $query->where('dasawismas.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('dasawismas.rt', 'LIKE', "%{$this->search}%")
                    ->orWhere('dasawismas.rw', 'LIKE', "%{$this->search}%")
                    ->orWhere('provinces.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('regencies.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('districts.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('villages.name', 'LIKE', "%{$this->search}%");
            })
            ->when($this->provinceId != '', function (Builder $query) {
                $query->where('dasawismas.province_id', 'LIKE', "%{$this->provinceId}%");
            })
            ->when($this->regencyId != '', function (Builder $query) {
                $query->where('dasawismas.regency_id', '=', $this->regencyId);
            })
            ->when($this->districtId != '', function (Builder $query) {
                $query->where('dasawismas.district_id', 'LIKE', "%{$this->districtId}%");
            })
            ->when($this->villageId != '', function (Builder $query) {
                $query->where('dasawismas.village_id', 'LIKE', "%{$this->villageId}%");
            })
            ->orderBy('dasawismas.id', 'DESC')
            ->paginate($this->perPage)->onEachSide(1);

        session()->put('dasawisma_url', request()->fullUrl());

        return view('livewire.app.backend.data-input.dasawisma-index', [
            'dasawismas' => $data,
        ]);
    }

    #[On('dasawisma-deleted')]
    public function delete($dasawismaId)
    {
        try {
            Dasawisma::where('id', '=', $dasawismaId)->delete();

            $paginator = Dasawisma::paginate($this->perPage);

            session()->flash('message', [
                'text' => 'Dasawisma berhasil dihapus!',
                'type' => 'success'
            ]);

            ($paginator->currentPage() <= $paginator->lastPage())
                ? $this->setPage($paginator->currentPage()) // still on the current page
                : $this->previousPage(); // move to last page

        } catch (\Exception $ex) {
            session()->flash('message', [
                'text' => 'Terjadi suatu kesalahan!!',
                'type' => 'danger'
            ]);

            $this->redirect(route('admin.data_input.dasawisma.index'), true);
        }
    }
}
