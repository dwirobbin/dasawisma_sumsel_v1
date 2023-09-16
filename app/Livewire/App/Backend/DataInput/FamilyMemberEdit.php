<?php

namespace App\Livewire\App\Backend\DataInput;

use App\Models\Family;
use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FamilyMemberEdit extends Component
{
    public $familyMembers = [];

    public $dasawismas = [];
    public string|int|null $familyId = NULL, $dasawismaId = NULL, $kkNumber = NULL, $kkHead = NULL;

    public function mount($data)
    {
        $this->dasawismas = Dasawisma::get(['id', 'name']);

        foreach ($data as $index => $familyMember) {
            if ($index === array_key_first($data)) {
                $this->familyId = data_get($familyMember, 'family.id');
                $this->dasawismaId = data_get($familyMember, 'family.dasawisma_id');
                $this->kkNumber = data_get($familyMember, 'family.kk_number');
                $this->kkHead = data_get($familyMember, 'family.kk_head');
            }

            array_push($this->familyMembers, [
                'id'                => $familyMember['id'],
                'family_id'         => $familyMember['family_id'],
                'nik_number'        => $familyMember['nik_number'],
                'name'              => $familyMember['name'],
                'birth_date'        => $familyMember['birth_date'],
                'status'            => $familyMember['status'],
                'marital_status'    => $familyMember['marital_status'],
                'gender'            => $familyMember['gender'],
                'last_education'    => $familyMember['last_education'],
                'profession'        => $familyMember['profession'],
                'family_member_count' => count($data),
            ]);
        }
    }

    public function updatedFamilyMembers0Name()
    {
        $this->kkHead = (string) str($this->familyMembers[0]['name'])->title();
    }

    public function updatedKkHead()
    {
        $this->familyMembers[0]['name'] = (string) str($this->kkHead)->title();
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.family-member-edit');
    }

    public function addFamilyMember()
    {
        $this->familyMembers[] = [
            'nik_number'        => '',
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

    public function update()
    {
        Validator::make([
            'dasawisma_id'                      => $this->dasawismaId,
            'kk_number'                         => $this->kkNumber,
            'kk_head'                           => $this->kkHead,
            'family_members'                    => $this->familyMembers,
        ], [
            'dasawisma_id'                      => ['required', 'numeric'],
            'kk_number'                         => ['required', 'numeric'],
            'kk_head'                           => ['required', 'string'],
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
            'required'                          => ':attribute wajib diisi.',
            'string'                            => ':attribute harus berupa string.',
            'numeric'                           => ':attribute harus berupa angka.',
            'family_members.*.*.required'       => ':attribute :position wajib diisi.',
            'family_members.*.*.string'         => ':attribute :position harus berupa string.',
            'family_members.*.*.numeric'        => ':attribute :position harus berupa angka.',
        ], [
            'dasawisma_id'                      => 'Dasawisma',
            'kk_number'                         => 'No. KK',
            'kk_head'                           => 'Nama Kepala Keluarga',
            'family_members.*.nik_number'       => 'No. NIK',
            'family_members.*.name'             => 'Nama',
            'family_members.*.birth_date'       => 'Tgl Lahir',
            'family_members.*.status'           => 'Status',
            'family_members.*.marital_status'   => 'Status Nikah',
            'family_members.*.gender'           => 'Jenis Kelamin',
            'family_members.*.last_education'   => 'Pendidikan Terakhir',
            'family_members.*.profession'       => 'Pekerjaan',
        ])->validate();

        try {
            DB::beginTransaction();

            foreach ($this->familyMembers as $familyMember) {
                if (isset($familyMember['id'])) {
                    FamilyMember::where('id', '=', $familyMember['id'])
                        ->update([
                            'family_id'         => $familyMember['family_id'],
                            'nik_number'        => $familyMember['nik_number'],
                            'name'              => str($familyMember['name'])->title(),
                            'slug'              => str($familyMember['name'])->slug(),
                            'birth_date'        => $familyMember['birth_date'],
                            'status'            => $familyMember['status'],
                            'marital_status'    => $familyMember['marital_status'],
                            'gender'            => $familyMember['gender'],
                            'last_education'    => $familyMember['last_education'],
                            'profession'        => $familyMember['profession'] ?: 'Belum/Tidak Bekerja',
                        ]);

                    Family::where('id', '=', $familyMember['family_id'])->update([
                        'dasawisma_id'  => $this->dasawismaId,
                        'kk_number'     => $this->kkNumber,
                        'kk_head'       => str($this->kkHead)->title(),
                        'user_id'       => auth()->id(),
                    ]);
                } else {
                    FamilyMember::create([
                        'family_id'         => $this->familyId,
                        'nik_number'        => $familyMember['nik_number'],
                        'name'              => str($familyMember['name'])->title(),
                        'slug'              => str($familyMember['name'])->slug(),
                        'birth_date'        => $familyMember['birth_date'],
                        'status'            => $familyMember['status'],
                        'marital_status'    => $familyMember['marital_status'],
                        'gender'            => $familyMember['gender'],
                        'last_education'    => $familyMember['last_education'],
                        'profession'        => $familyMember['profession'] ?: 'Belum/Tidak Bekerja',
                    ]);
                }
            }

            DB::commit();

            session()->flash('message', [
                'text' => "Data Anggota Keluarga {$this->kkHead} berhasil diperbarui!",
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
