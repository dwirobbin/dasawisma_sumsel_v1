<?php

namespace App\Livewire\App\Backend\DataRecap;

use Livewire\Component;
use App\Models\FamilyNumber;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use RalphJSmit\Livewire\Urls\Facades\Url as LivewireUrl;

class FamilyNumberIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $param = '';

    public int $perPage = 5;

    #[Url()]
    public string $search = '';

    public $currentUrl;

    public function mount()
    {
        $this->currentUrl = LivewireUrl::current();
    }

    public function placeholder()
    {
        return view('placeholder');
    }

    public function render()
    {
        $param = match (true) {
            str_contains($this->currentUrl, '/area') && strlen((string) $this->param) == 4 => $this->param,
            str_contains($this->currentUrl, '/area') && strlen((string) $this->param) == 7 => $this->param,
            str_contains($this->currentUrl, '/area') && strlen((string) $this->param) == 10 => $this->param,
            str_contains($this->currentUrl, '/dasawisma') => 'dasawisma',
            default => 'index'
        };

        $familyNumbers = FamilyNumber::selectRaw("
            SUM(toddlers_number) AS toddlers_sum,
            SUM(pus_number) AS pus_sum,
            SUM(wus_number) AS wus_sum,
            SUM(blind_people_number) AS blind_peoples_sum,
            SUM(pregnant_women_number) AS pregnant_womens_sum,
            SUM(breastfeeding_mother_number) AS breastfeeding_mothers_sum,
            SUM(elderly_number) AS elderlies_sum
        ")
            ->join('families', 'family_numbers.family_id', '=', 'families.id')
            ->join('dasawismas', 'families.dasawisma_id', '=', 'dasawismas.id')
            ->when($this->param == 'index', function (Builder $query) {
                $query->addSelect('regencies.id', 'regencies.name')
                    ->join('regencies', 'dasawismas.regency_id', '=', 'regencies.id')
                    ->where('dasawismas.province_id', '=', 16)
                    ->when($this->search != '', function (Builder $query) {
                        $query->where('regencies.name', 'LIKE', '%' . trim($this->search) . '%');
                    })
                    ->groupBy('regencies.id')
                    ->orderBy('dasawismas.regency_id', 'ASC');
            })
            ->when(strlen((string) $param) == 4, function (Builder $query) {
                $query->addSelect('districts.id', 'districts.name')
                    ->join('districts', 'dasawismas.district_id', '=', 'districts.id')
                    ->where('dasawismas.regency_id', '=', $this->param)
                    ->when($this->search != '', function (Builder $query) {
                        $query->where('districts.name', 'LIKE', '%' . trim($this->search) . '%');
                    })
                    ->groupBy('districts.id')
                    ->orderBy('dasawismas.regency_id', 'ASC');
            })
            ->when(strlen((string) $param) == 7, function (Builder $query) {
                $query->addSelect('villages.id', 'villages.name')
                    ->join('villages', 'dasawismas.village_id', '=', 'villages.id')
                    ->where('dasawismas.district_id', '=', $this->param)
                    ->when($this->search != '', function (Builder $query) {
                        $query->where('villages.name', 'LIKE', '%' . trim($this->search) . '%');
                    })
                    ->groupBy('villages.id')
                    ->orderBy('dasawismas.district_id', 'ASC');
            })
            ->when(strlen((string) $param) == 10, function (Builder $query) {
                $query->addSelect('dasawismas.id', 'dasawismas.name', 'dasawismas.slug')
                    ->where('dasawismas.village_id', '=', $this->param)
                    ->when($this->search != '', function (Builder $query) {
                        $query->where('dasawismas.name', 'LIKE', '%' . trim($this->search) . '%');
                    })
                    ->groupBy('dasawismas.id')
                    ->orderBy('dasawismas.village_id', 'ASC');
            })
            ->when($param == 'dasawisma', function (Builder $query) {
                $query->addSelect('families.id', 'families.kk_head AS name')
                    ->where('dasawismas.slug', '=', $this->param)
                    ->when($this->search != '', function (Builder $query) {
                        $query->where('families.kk_head', 'LIKE', '%' . trim($this->search) . '%');
                    })
                    ->groupBy('families.id')
                    ->orderBy('family_numbers.family_id', 'ASC');
            })
            ->get();

        return view('livewire.app.backend.data-recap.family-number-index', [
            'data' => $familyNumbers->paginate($this->perPage),
        ]);
    }
}
