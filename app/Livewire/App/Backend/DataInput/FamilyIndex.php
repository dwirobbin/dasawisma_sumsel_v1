<?php

namespace App\Livewire\App\Backend\DataInput;

use App\Models\Family;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class FamilyIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 5;

    #[Url()]
    public string $search = '';

    public function placeholder()
    {
        return view('placeholder');
    }

    public function render()
    {
        $data = Family::selectRaw("
                families.id,
                IF(dasawismas.name IS NULL, 'Belum di set', dasawismas.name) AS dasawisma_name,
                families.kk_number, families.kk_head,
                IF(families.dasawisma_id IS NULL, 'Belum di set', CONCAT_WS(', ', provinces.name, regencies.name, districts.name, villages.name)) AS area
            ")
            ->leftJoin('dasawismas', 'families.dasawisma_id', '=', 'dasawismas.id')
            ->leftJoin('provinces', 'dasawismas.province_id', '=', 'provinces.id')
            ->leftJoin('regencies', 'dasawismas.regency_id', '=', 'regencies.id')
            ->leftJoin('districts', 'dasawismas.district_id', '=', 'districts.id')
            ->leftJoin('villages', 'dasawismas.village_id', '=', 'villages.id')
            ->when($this->search != '',  function (Builder $query) {
                $query->where('families.kk_number', 'LIKE', "%{$this->search}%")
                    ->orWhere('families.kk_head', 'LIKE', "%{$this->search}%")
                    ->orWhere('dasawismas.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('provinces.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('regencies.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('districts.name', 'LIKE', "%{$this->search}%")
                    ->orWhere('villages.name', 'LIKE', "%{$this->search}%");
            })
            ->orderBy('families.id', 'DESC')
            ->paginate($this->perPage)->onEachSide(1);

        return view('livewire.app.backend.data-input.family-index', [
            'families' => $data,
        ]);
    }

    #[On('family-deleted')]
    public function delete($id)
    {
        try {
            Family::where('id', '=', $id)->delete();

            $paginator = Family::paginate($this->perPage);

            session()->flash('message', [
                'text' => 'Kepala Keluarga berhasil dihapus!',
                'type' => 'success'
            ]);

            $this->dispatch('family-deleted-success');

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
