<?php

namespace App\Livewire\App\Backend\DataInput;

use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Province;
use App\Models\Dasawisma;
use Illuminate\Support\Facades\Validator;

class DasawismaCreate extends Component
{
    public $provinces = [], $regencies = [], $districts = [], $villages = [];

    public ?string $name = '', $rt = null, $rw = null;
    public string $provinceId = '', $regencyId = '', $districtId = '', $villageId = '';

    public function mount()
    {
        $this->provinces = Province::select(['id', 'name'])->get();
    }

    public function updatedProvinceId($provinceId)
    {
        if ($this->provinceId !== '') {
            $this->regencies = Regency::select(['id', 'name'])
                ->where('province_id', '=', $provinceId)
                ->orderBy('name')
                ->get();

            $this->reset('districtId', 'villageId');
        } else {
            $this->reset('regencies', 'districts', 'villages');
        }
    }

    public function updatedRegencyId($regencyId)
    {
        if ($this->regencyId !== '') {
            $this->districts = District::select(['id', 'name'])
                ->where('regency_id', '=', $regencyId)
                ->orderBy('name')
                ->get();

            $this->reset('villageId');
        } else {
            $this->reset('districts', 'villages');
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
            $this->reset('villages');
        }
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.dasawisma-create');
    }

    public function store()
    {
        $validator = Validator::make([
            'name'          => $this->name,
            'rt'            => $this->rt ?? null,
            'rw'            => $this->rw ?? null,
            'province_id'   => $this->provinceId,
            'regency_id'    => $this->regencyId,
            'district_id'   => $this->districtId,
            'village_id'    => $this->villageId,
        ], [
            'name'          => ['required', 'string'],
            'rt'            => ['nullable', 'sometimes', 'numeric'],
            'rw'            => ['nullable', 'sometimes', 'numeric'],
            'province_id'   => ['required'],
            'regency_id'    => ['required'],
            'district_id'   => ['required'],
            'village_id'    => ['required'],
        ], [
            'required'  => ':attribute wajib diisi.',
            'string'    => ':attribute harus berupa string.',
            'numeric'   => ':attribute harus berupa angka.',
        ], [
            'name'          => 'Nama Dasawisma',
            'rt'            => 'RT',
            'rw'            => 'RW',
            'province_id'   => 'Provinsi',
            'regency_id'    => 'Kabupaten/Kota',
            'district_id'   => 'Kecamatan',
            'village_id'    => 'Kelurahan/Desa',
        ]);

        $validateData = $validator->validate();

        try {
            if ($validator->passes()) {
                $validateData['name'] = str($this->name)->title();
                $validateData['slug'] = str($this->name)->slug();
            }

            Dasawisma::create($validateData);

            session()->flash('message', [
                'text' => 'Dasawisma Baru berhasil ditambahkan!',
                'type' => 'success'
            ]);
        } catch (\Exception $ex) {
            session()->flash('message', [
                'text' => 'Terjadi suatu kesalahan!!',
                'type' => 'danger'
            ]);
        }

        return $this->redirect(route('admin.data_input.dasawisma.index'), true);
    }
}
