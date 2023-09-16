<?php

namespace App\Livewire\App\Backend\DataInput;

use App\Models\Family;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\FamilyMember;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class FamilyMemberIndex extends Component
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
        $families = DB::table('families')
            ->selectRaw("families.*, COUNT(family_members.family_id) AS family_members_count")
            ->join('family_members', 'families.id', '=', 'family_members.family_id')
            ->groupBy('family_members.family_id');

        $familyMembers = FamilyMember::selectRaw("
                family_members.id,
                IF(dasawismas.name IS NULL, 'Belum di set', dasawismas.name) AS dasawisma_name,
                IF(families.dasawisma_id IS NULL, 'Belum di set', CONCAT_WS(', ', provinces.name, regencies.name, districts.name, villages.name)) AS area,
                families.kk_number, family_members.name, family_members.nik_number,
                family_members.birth_date, family_members.status, family_members.marital_status,
                family_members.gender, family_members.last_education, family_members.profession,
                families.family_members_count
            ")
            ->leftJoinSub($families, 'families', function (JoinClause  $join) {
                $join->on('family_members.family_id', '=', 'families.id');
            })
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
                    ->orWhere('families.kk_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_members.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_members.nik_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_members.birth_date', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_members.status', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_members.marital_status', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_members.gender', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_members.last_education', 'LIKE', "%{$this->search}%")
                    ->orWhere('family_members.profession', 'LIKE', "%{$this->search}%");
            })
            ->orderBy('family_members.family_id', 'DESC')
            ->orderBy('family_members.status',  'ASC')
            ->paginate($this->perPage);

        $data = $familyMembers->setCollection($familyMembers->groupBy(fn ($column) => $column->kk_number));

        return view('livewire.app.backend.data-input.family-member-index', [
            'family_members' => $data,
        ]);
    }

    #[On('family-member-deleted')]
    public function delete($id)
    {
        try {
            FamilyMember::where('id', '=', $id)->delete();

            $paginator = FamilyMember::paginate($this->perPage);

            session()->flash('message', [
                'text' => 'Anggota Keluarga berhasil dihapus!',
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

            $this->redirect(route('admin.data_input.member.index'), true);
        }
    }
}
