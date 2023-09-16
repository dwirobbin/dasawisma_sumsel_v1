<?php

namespace App\Livewire\App\Backend\DataInput;

use App\Models\Family;
use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyMember;
use App\Models\FamilyNumber;
use App\Models\FamilyActivity;
use App\Models\FamilyBuilding;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MemberCreate extends Component
{
    public $dasawismas = [];

    public int $currentStep = 1;

    public ?string $dasawismaId = NULL, $kkNumber = NULL, $kkHead = NULL;
    public $waterSrc = [];
    public ?string $stapleFood = NULL, $haveToilet = NULL, $haveLandfill = NULL, $haveSewerage = NULL, $pastingP4kSticker = NULL, $houseCriteria = NULL;
    public ?int $toddlersNumber = NULL, $pusNumber = NULL, $wusNumber = NULL, $blindPeopleNumber = NULL, $pregnantWomenNumber = NULL, $breastfeedingMotherNumber = NULL, $elderlyNumber = NULL;
    public $familyMembers = [];
    public ?string $up2kActivity = NULL, $envHealthActivity = NULL;

    public function mount()
    {
        $this->dasawismas = Dasawisma::get(['id', 'name']);
        $this->familyMembers = [[
            'nik_number'        => NULL,
            'name'              => '',
            'birth_date'        => '',
            'status'            => NULL,
            'marital_status'    => '',
            'gender'            => '',
            'last_education'    => '',
            'profession'        => '',
        ]];
    }

    public function updatedKkHead()
    {
        $this->familyMembers[0]['name'] = (string) str($this->kkHead)->title();
        $this->familyMembers[0]['status'] = 'Kepala Keluarga';
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.member-create');
    }


    public function firstStepSubmit()
    {
        Validator::make([
            'dasawisma_id'  => $this->dasawismaId,
            'kk_number'     => $this->kkNumber,
            'kk_head'       => $this->kkHead,
        ], [
            'dasawisma_id'  => ['required', 'string',],
            'kk_number'     => ['required', 'numeric',],
            'kk_head'       => ['required', 'string',],
        ], [
            'required'      => ':attribute wajib diisi.',
            'string'        => ':attribute harus berupa string.',
            'numeric'       => ':attribute harus berupa angka.',
        ], [
            'dasawisma_id'  => 'Dasawisma',
            'kk_number'     => 'No. KK',
            'kk_head'       => 'Nama Kepala Keluarga',
        ])->validate();

        $this->currentStep = 2;
    }

    public function secondStepSubmit()
    {
        Validator::make([
            'staple_food'           => $this->stapleFood,
            'water_src'             => $this->waterSrc,
            'have_toilet'           => $this->haveToilet,
            'have_landfill'         => $this->haveLandfill,
            'have_sewerage'         => $this->haveSewerage,
            'pasting_p4k_sticker'   => $this->pastingP4kSticker,
            'house_criteria'        => $this->houseCriteria,
        ], [
            'staple_food'           => ['required'],
            'water_src'             => ['required'],
            'have_toilet'           => ['required'],
            'have_landfill'         => ['required'],
            'have_sewerage'         => ['required'],
            'pasting_p4k_sticker'   => ['required'],
            'house_criteria'        => ['required'],
        ], [
            'required'              => ':attribute wajib diisi.',
        ], [
            'staple_food'           => 'Makanan Pokok',
            'have_toilet'           => 'Mempunyai Toilet',
            'water_src'             => 'Sumber Air Keluarga',
            'have_landfill'         => 'Mempunyai TPS',
            'have_sewerage'         => 'Mempunyai SPAL',
            'pasting_p4k_sticker'   => 'Menempel Stiker P4K',
            'house_criteria'        => 'Kriteria Rumah',
        ])->validate();

        $this->currentStep = 3;
    }

    public function thirdStepSubmit()
    {
        Validator::make([
            'toddlers_number'               => $this->toddlersNumber,
            'pus_number'                    => $this->pusNumber,
            'wus_number'                    => $this->wusNumber,
            'blind_people_number'           => $this->blindPeopleNumber,
            'pregnant_women_number'         => $this->pregnantWomenNumber,
            'breastfeeding_mother_number'   => $this->breastfeedingMotherNumber,
            'elderly_number'                => $this->elderlyNumber,
        ], [
            'toddlers_number'               => ['nullable', 'numeric'],
            'pus_number'                    => ['nullable', 'numeric'],
            'wus_number'                    => ['nullable', 'numeric'],
            'blind_people_number'           => ['nullable', 'numeric'],
            'pregnant_women_number'         => ['nullable', 'numeric'],
            'breastfeeding_mother_number'   => ['nullable', 'numeric'],
            'elderly_number'                => ['nullable', 'numeric'],
        ], [
            'numeric'   => ':attribute harus berupa angka.',
        ], [
            'toddlers_number'               => 'Jmlh Balita',
            'pus_number'                    => 'Jmlh PUS',
            'wus_number'                    => 'Jmlh WUS',
            'blind_people_number'           => 'Jmlh Orang Buta',
            'pregnant_women_number'         => 'Jmlh Ibu Hamil',
            'breastfeeding_mother_number'   => 'Jmlh Ibu Menyusui',
            'elderly_number'                => 'Jmlh Lansia',
        ])->validate();

        $this->currentStep = 4;
    }

    public function forthStepSubmit()
    {
        Validator::make([
            'family_members' => $this->familyMembers,
        ], [
            'family_members'                    => ['required', 'array'],
            'family_members.*.nik_number'       => ['nullable', 'numeric'],
            'family_members.*.name'             => ['required', 'string'],
            'family_members.*.birth_date'       => ['required', 'string'],
            'family_members.*.status'           => ['required', 'string'],
            'family_members.*.marital_status'   => ['required', 'string'],
            'family_members.*.gender'           => ['required', 'string', 'in:Laki-laki,Perempuan'],
            'family_members.*.last_education'   => ['required', 'string'],
            'family_members.*.profession'       => ['nullable', 'string'],
        ], [
            'required'  => ':attribute :position wajib diisi.',
            'numeric'   => ':attribute :position harus berupa angka.',
            'string'    => ':attribute :position harus berupa string.',
        ], [
            'family_members.*.nik_number'       => 'No. NIK',
            'family_members.*.name'             => 'Nama',
            'family_members.*.birth_date'       => 'Tgl Lahir',
            'family_members.*.status'           => 'Status',
            'family_members.*.marital_status'   => 'Status Nikah',
            'family_members.*.gender'           => 'Jenis Kelamin',
            'family_members.*.last_education'   => 'Pendidikan Terakhir',
            'family_members.*.profession'       => 'Pekerjaan',
        ])->validate();

        $this->currentStep = 5;
    }

    public function submitForm()
    {
        Validator::make([
            'up2k_activity'         => $this->up2kActivity,
            'env_health_activity'   => $this->envHealthActivity,
        ], [
            'up2k_activity'         => ['nullable', 'string'],
            'env_health_activity'   => ['nullable', 'string'],
        ], [
            'string'    => ':attribute harus berupa string.'
        ], [
            'up2k_activity'         => 'Kegiatan Usaha Peningkatan Pendapatan Keluarga',
            'env_health_activity'   => 'Kegiatan Usaha Kesehatan Lingkungan',
        ])->validate();

        try {
            DB::beginTransaction();

            $family = Family::create([
                'dasawisma_id'  => $this->dasawismaId,
                'kk_number'     => $this->kkNumber,
                'kk_head'       => str($this->kkHead)->title(),
                'user_id'       => auth()->id(),
            ]);

            FamilyBuilding::create([
                'family_id'             => $family->id,
                'staple_food'           => $this->stapleFood,
                'have_toilet'           => $this->haveToilet ?? false,
                'water_src'             => implode(',', (array) $this->waterSrc),
                'have_landfill'         => $this->haveLandfill ?? false,
                'have_sewerage'         => $this->haveSewerage ?? false,
                'pasting_p4k_sticker'   => $this->pastingP4kSticker ?? false,
                'house_criteria'        => $this->houseCriteria,
            ]);

            FamilyNumber::create([
                'family_id'                     => $family->id,
                'toddlers_number'               => $this->toddlersNumber ?? 0,
                'pus_number'                    => $this->pusNumber ?? 0,
                'wus_number'                    => $this->wusNumber ?? 0,
                'blind_people_number'           => $this->blindPeopleNumber ?? 0,
                'pregnant_women_number'         => $this->pregnantWomenNumber ?? 0,
                'breastfeeding_mother_number'   => $this->breastfeedingMotherNumber ?? 0,
                'elderly_number'                => $this->elderlyNumber ?? 0,
            ]);

            foreach ($this->familyMembers as $familyMember) {
                FamilyMember::create([
                    'family_id'         => $family->id,
                    'nik_number'        => $familyMember['nik_number'],
                    'name'              => str($familyMember['name'])->title(),
                    'slug'              => $familyMember['name'],
                    'birth_date'        => $familyMember['birth_date'],
                    'status'            => $familyMember['status'],
                    'marital_status'    => $familyMember['marital_status'],
                    'gender'            => $familyMember['gender'],
                    'last_education'    => $familyMember['last_education'],
                    'profession'        => $familyMember['profession'] ?: 'Belum/Tidak Bekerja',
                ]);
            }

            FamilyActivity::create([
                'family_id'             => $family->id,
                'up2k_activity'         => $this->up2kActivity,
                'env_health_activity'   => $this->envHealthActivity,
            ]);

            DB::commit();

            session()->flash('message', [
                'text' => 'Anggota Baru berhasil ditambahkan!',
                'type' => 'success'
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();

            session()->flash('message', [
                'text' => 'Terjadi suatu kesalahan',
                'type' => 'danger'
            ]);
        }

        $this->currentStep = 1;

        return $this->redirect(route('admin.data_input.member.index', true));
    }

    public function back($step)
    {
        $this->currentStep = $step;
    }

    public function addFamilyMember()
    {
        $this->familyMembers[] = [
            'nik_number'        => NULL,
            'name'              => '',
            'birth_date'        => '',
            'status'            => NULL,
            'marital_status'    => '',
            'gender'            => '',
            'last_education'    => '',
            'profession'        => '',
        ];
    }

    public function removeFamilyMember($index)
    {
        unset($this->familyMembers[$index]);
        $this->familyMembers = array_values($this->familyMembers);
    }
}
