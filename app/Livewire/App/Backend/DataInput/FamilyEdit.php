<?php

namespace App\Livewire\App\Backend\DataInput;

use App\Models\Family;
use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FamilyEdit extends Component
{
    public ?Family $family = NULL;
    public ?FamilyMember $familyMember = NULL;

    public $dasawismas = [];
    public ?string $dasawismaId = NULL, $kkNumber = NULL, $kkHead = NULL;

    public function mount($data)
    {
        $this->family = $data;
        $this->familyMember = FamilyMember::select(['id', 'name', 'slug'])
            ->where([['family_id', '=', $data->id], ['name', '=', $data->kk_head]])
            ->first();

        $this->dasawismas = Dasawisma::get(['id', 'name']);

        $this->dasawismaId = $data->dasawisma_id;
        $this->kkNumber = $data->kk_number;
        $this->kkHead = $data->kk_head;
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.family-edit');
    }

    public function update()
    {
        $validateData = Validator::make([
            'dasawisma_id'          => $this->dasawismaId,
            'kk_number'             => $this->kkNumber,
            'kk_head'               => $this->kkHead,
        ], [
            'dasawisma_id'          => ['required', 'string'],
            'kk_number'             => ['required', 'numeric'],
            'kk_head'               => ['required', 'string'],
        ], [
            'required'              => ':attribute wajib diisi.',
            'string'                => ':attribute harus berupa string.',
            'numeric'               => ':attribute harus berupa angka.',
        ], [
            'dasawisma_id'          => 'Dasawisma',
            'kk_number'             => 'No. KK',
            'kk_head'               => 'Nama Kepala Keluarga',
        ])->validate();

        try {
            DB::beginTransaction();

            $this->family->update([
                'dasawisma_id' => $validateData['dasawisma_id'],
                'kk_number'    => $validateData['kk_number'],
                'kk_head'      => str($validateData['kk_head'])->title(),
            ]);

            $this->familyMember->update([
                'name'  => str($validateData['kk_head'])->title(),
                'slug'  => str($validateData['kk_head'])->slug(),
            ]);

            DB::commit();

            session()->flash('message', [
                'text' => "Data Kepala Keluarga {$this->family->kk_head} berhasil diperbarui!",
                'type' => 'success'
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();

            session()->flash('message', [
                'text' => 'Terjadi suatu kesalahan!!',
                'type' => 'danger'
            ]);
        }

        return $this->redirect(route('admin.data_input.member.index', true));
    }
}
