<?php

namespace App\Livewire\App\Backend\DataRecap;

use Livewire\Component;
use App\Models\FamilyMember;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use RalphJSmit\Livewire\Urls\Facades\Url as LivewireUrl;

class FamilyMemberIndex extends Component
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

        $familyMembers = FamilyMember::selectRaw("
            COUNT(family_members.family_id) AS family_members_count,
            COUNT(CASE WHEN family_members.gender = 'Laki-laki' THEN 1 END) AS genders_male_count,
            COUNT(CASE WHEN family_members.gender = 'Perempuan' THEN 1 END) AS genders_female_count,
            COUNT(CASE WHEN family_members.marital_status = 'Kawin' THEN 1 END) AS marries_count,
            COUNT(CASE WHEN family_members.marital_status = 'Belum Kawin' THEN 1 END) AS singles_count,
            COUNT(CASE WHEN family_members.marital_status = 'Janda' THEN 1 END) AS widows_count,
            COUNT(CASE WHEN family_members.marital_status = 'Duda' THEN 1 END) AS widowers_count,
            COUNT(CASE WHEN family_members.profession != 'Belum/Tidak Bekerja' THEN 1 END) AS workings_count,
            COUNT(CASE WHEN family_members.profession LIKE '%Tidak Bekerja%' THEN 1 END) AS not_workings_count,
            COUNT(CASE WHEN family_members.last_education = 'TK/PAUD' THEN 1 END) AS kindergartens_count,
            COUNT(CASE WHEN family_members.last_education = 'SD/MI' THEN 1 END) AS elementary_schools_count,
            COUNT(CASE WHEN family_members.last_education = 'SLTP/SMP/MTS' THEN 1 END) AS middle_schools_count,
            COUNT(CASE WHEN family_members.last_education = 'SLTA/SMA/MA/SMK' THEN 1 END) AS high_schools_count,
            COUNT(CASE WHEN family_members.last_education = 'Diploma' THEN 1 END) AS associate_degrees_count,
            COUNT(CASE WHEN family_members.last_education = 'S1' THEN 1 END) AS bachelor_degrees_count,
            COUNT(CASE WHEN family_members.last_education = 'S2' THEN 1 END) AS master_degrees_count,
            COUNT(CASE WHEN family_members.last_education = 'S3' THEN 1 END) AS post_degrees_count
        ")
            ->join('families', 'family_members.family_id', '=', 'families.id')
            ->join('dasawismas', 'families.dasawisma_id', '=', 'dasawismas.id')
            ->when($param == 'index', function (Builder $query) {
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
                    ->orderBy('family_members.family_id', 'ASC');
            })
            ->get();

        return view('livewire.app.backend.data-recap.family-member-index', [
            'data' => $familyMembers->paginate($this->perPage),
        ]);
    }
}
