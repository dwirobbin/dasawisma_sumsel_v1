<?php

namespace App\Livewire\App\Backend\DataInput;

use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyActivity;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FamilyActivityEdit extends Component
{
    public ?FamilyActivity $familyActivity = NULL;
    public ?FamilyMember $familyMember = NULL;

    public $dasawismas = [];
    public ?string $dasawismaId = NULL, $kkNumber = NULL, $kkHead = NULL;
    public ?string $up2kActivity = NULL, $envHealthActivity = NULL;

    public function mount($data)
    {
        $this->familyActivity = $data;
        $this->familyMember = FamilyMember::select(['id', 'name', 'slug'])
            ->where([['family_id', '=', $data->family->id], ['name', '=', $data->family->kk_head]])
            ->first();

        $this->dasawismas = Dasawisma::get(['id', 'name']);

        $this->dasawismaId = $data->family->dasawisma_id;
        $this->kkNumber = $data->family->kk_number;
        $this->kkHead = $data->family->kk_head;
        $this->up2kActivity = $data->up2k_activity;
        $this->envHealthActivity = $data->env_health_activity;
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.family-activity-edit');
    }

    public function update()
    {
        $validateData = Validator::make([
            'dasawisma_id'          => $this->dasawismaId,
            'kk_number'             => $this->kkNumber,
            'kk_head'               => $this->kkHead,
            'up2k_activity'         => $this->up2kActivity,
            'env_health_activity'   => $this->envHealthActivity,
        ], [
            'dasawisma_id'          => ['required', 'string'],
            'kk_number'             => ['required', 'numeric'],
            'kk_head'               => ['required', 'string'],
            'up2k_activity'         => ['nullable', 'string'],
            'env_health_activity'   => ['nullable', 'string'],
        ], [
            'required'              => ':attribute wajib diisi.',
            'string'                => ':attribute harus berupa string.',
            'numeric'               => ':attribute harus berupa angka.',
        ], [
            'dasawisma_id'          => 'Dasawisma',
            'kk_number'             => 'No. KK',
            'kk_head'               => 'Nama Kepala Keluarga',
            'up2k_activity'         => 'Kegiatan Usaha Peningkatan Pendapatan Keluarga',
            'env_health_activity'   => 'Kegiatan Usaha Kesehatan Lingkungan',
        ])->validate();

        try {
            DB::beginTransaction();

            $this->familyActivity->update([
                'up2k_activity'         => $validateData['up2k_activity'],
                'env_health_activity'   => $validateData['env_health_activity'],
            ]);

            $this->familyMember->update([
                'name'  => str($validateData['kk_head'])->title(),
                'slug'  => str($validateData['kk_head'])->slug(),
            ]);

            $this->familyActivity->family->update([
                'dasawisma_id' => $validateData['dasawisma_id'],
                'kk_number'    => $validateData['kk_number'],
                'kk_head'      => $validateData['kk_head'],
            ]);

            DB::commit();

            session()->flash('message', [
                'text' => "Data Akktifitas dari {$this->familyActivity->family->kk_head} berhasil diperbarui!",
                'type' => 'success',
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();

            session()->flash('message', [
                'text' => 'Terjadi suatu kesalahan!!',
                'type' => 'danger',
            ]);
        }

        return $this->redirect(route('admin.data_input.member.index', true));
    }
}
