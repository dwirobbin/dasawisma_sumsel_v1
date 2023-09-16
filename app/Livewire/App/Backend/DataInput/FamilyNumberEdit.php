<?php

namespace App\Livewire\App\Backend\DataInput;

use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyMember;
use App\Models\FamilyNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FamilyNumberEdit extends Component
{
    public ?FamilyNumber $familyNumber = NULL;
    public ?FamilyMember $familyMember = NULL;

    public $dasawismas = [];
    public ?string $dasawismaId = NULL, $kkNumber = NULL, $kkHead = NULL;
    public ?int $toddlersNumber = NULL, $pusNumber = NULL, $wusNumber = NULL, $blindPeopleNumber = NULL, $pregnantWomenNumber = NULL, $breastfeedingMotherNumber = NULL, $elderlyNumber = NULL;

    public function mount($data)
    {
        $this->familyNumber = $data;
        $this->familyMember = FamilyMember::select(['id', 'name', 'slug'])
            ->where([['family_id', '=', $data->family->id], ['name', '=', $data->family->kk_head]])
            ->first();

        $this->dasawismas = Dasawisma::get(['id', 'name']);

        $this->dasawismaId = $data->family->dasawisma_id;
        $this->kkNumber = $data->family->kk_number;
        $this->kkHead = $data->family->kk_head;

        $this->toddlersNumber = $data->toddlers_number;
        $this->pusNumber = $data->pus_number;
        $this->wusNumber = $data->wus_number;
        $this->blindPeopleNumber = $data->blind_people_number;
        $this->pregnantWomenNumber = $data->pregnant_women_number;
        $this->breastfeedingMotherNumber = $data->breastfeeding_mother_number;
        $this->elderlyNumber = $data->elderly_number;
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.family-number-edit');
    }

    public function update()
    {
        $validateData = Validator::make([
            'dasawisma_id'                  => $this->dasawismaId,
            'kk_number'                     => $this->kkNumber,
            'kk_head'                       => $this->kkHead,
            'toddlers_number'               => $this->toddlersNumber,
            'pus_number'                    => $this->pusNumber,
            'wus_number'                    => $this->wusNumber,
            'blind_people_number'           => $this->blindPeopleNumber,
            'pregnant_women_number'         => $this->pregnantWomenNumber,
            'breastfeeding_mother_number'   => $this->breastfeedingMotherNumber,
            'elderly_number'                => $this->elderlyNumber,
        ], [
            'dasawisma_id'                  => ['required', 'string',],
            'kk_number'                     => ['required', 'numeric',],
            'kk_head'                       => ['required', 'string',],
            'toddlers_number'               => ['required'],
            'pus_number'                    => ['required'],
            'wus_number'                    => ['required'],
            'blind_people_number'           => ['required'],
            'pregnant_women_number'         => ['required'],
            'breastfeeding_mother_number'   => ['required'],
            'elderly_number'                => ['required'],
        ], [
            'required'                      => ':attribute wajib diisi.',
            'string'                        => ':attribute harus berupa string.',
            'numeric'                       => ':attribute harus berupa angka.',
        ], [
            'dasawisma_id'                  => 'Dasawisma',
            'kk_number'                     => 'No. KK',
            'kk_head'                       => 'Nama Kepala Keluarga',
            'toddlers_number'               => 'Jumlah Bayi',
            'pus_number'                    => 'Jumlah Pasangan Usia Subur',
            'wus_number'                    => 'Jumlah Wanita Usia Subur',
            'blind_people_number'           => 'Jumlah Orang Buta',
            'pregnant_women_number'         => 'Jumlah Ibu Hamil',
            'breastfeeding_mother_number'   => 'Jumlah Ibu Menyusui',
            'elderly_number'                => 'Jumlah Lansia',
        ])->validate();

        try {
            DB::beginTransaction();

            $this->familyNumber->update([
                'toddlers_number'               => $validateData['toddlers_number'],
                'pus_number'                    => $validateData['pus_number'],
                'wus_number'                    => $validateData['wus_number'],
                'blind_people_number'           => $validateData['blind_people_number'],
                'pregnant_women_number'         => $validateData['pregnant_women_number'],
                'breastfeeding_mother_number'   => $validateData['breastfeeding_mother_number'],
                'elderly_number'                => $validateData['elderly_number'],
            ]);

            $this->familyMember->update([
                'name'  => str($validateData['kk_head'])->title(),
                'slug'  => str($validateData['kk_head'])->slug(),
            ]);

            $this->familyNumber->family->update([
                'dasawisma_id' => $validateData['dasawisma_id'],
                'kk_number'    => $validateData['kk_number'],
                'kk_head'      => $validateData['kk_head'],
            ]);

            DB::commit();

            session()->flash('message', [
                'text' => "Data Jumlah Anggota milik {$this->familyNumber->family->kk_head} berhasil diperbarui!",
                'type' => 'success',
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();

            session()->flash('message', [
                'text' => 'Terjadi suatu kesalahan',
                'type' => 'danger'
            ]);
        }

        return $this->redirect(route('admin.data_input.member.index', true));
    }
}
