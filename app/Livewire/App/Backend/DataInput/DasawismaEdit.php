<?php

namespace App\Livewire\App\Backend\DataInput;

use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Province;
use App\Models\Dasawisma;
use Illuminate\Support\Facades\Validator;

class DasawismaEdit extends Component
{
    public ?Dasawisma $dasawisma;

    public $provinces = [], $regencies = [], $districts = [], $villages = [];

    public ?string $name = '', $rt = null, $rw = null;
    public ?string $provinceId = '', $regencyId = '', $districtId = '', $villageId = '';

    public function mount(Dasawisma $dasawisma)
    {
        $this->provinces = Province::get(['id', 'name']);

        $this->dasawisma   = $dasawisma;
        $this->name        = $dasawisma->name;
        $this->rt          = $dasawisma->rt;
        $this->rw          = $dasawisma->rw;
        $this->provinceId  = $dasawisma->province_id;
        $this->regencyId   = $dasawisma->regency_id;
        $this->districtId  = $dasawisma->district_id;
        $this->villageId   = $dasawisma->village_id;

        if ($this->provinceId !== null) {
            $this->regencies = Regency::where('province_id', '=', $dasawisma->province_id)
                ->orderBy('name')
                ->get(['id', 'name']);
        }

        if ($this->regencyId !== null) {
            $this->districts = District::where('regency_id', '=', $dasawisma->regency_id)
                ->orderBy('name')
                ->get(['id', 'name']);
        }

        if ($this->districtId !== null || $this->villageId !== null) {
            $this->villages = Village::where('district_id', '=', $dasawisma->district_id)
                ->orderBy('name')
                ->get(['id', 'name']);
        }
    }

    public function updatedProvinceId($provinceId)
    {
        if ($this->provinceId !== '') {
            $this->regencies    = Regency::where('province_id', '=', $provinceId)
                ->orderBy('name')
                ->get(['id', 'name']);
            $this->reset('districtId', 'villageId');
        } else {
            $this->reset('regencies', 'districts', 'villages');
        }
    }

    public function updatedRegencyId($regencyId)
    {
        if ($this->regencyId !== '') {
            $this->districts = District::where('regency_id', '=', $regencyId)
                ->orderBy('name')
                ->get(['id', 'name']);
            $this->reset('villageId');
        } else {
            $this->reset('districts', 'villages');
        }
    }

    public function updatedDistrictId($districtId)
    {
        if ($this->districtId !== '') {
            $this->villages = Village::where('district_id', '=', $districtId)
                ->orderBy('name')
                ->get(['id', 'name']);
        } else {
            $this->reset('villages');
        }
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.dasawisma-edit');
    }

    public function update()
    {
        $validator = Validator::make([
            'name'          => $this->name,
            'rt'            => $this->rt,
            'rw'            => $this->rw,
            'province_id'   => $this->provinceId ?: null,
            'regency_id'    => $this->regencyId ?: null,
            'district_id'   => $this->districtId ?: null,
            'village_id'    => $this->villageId ?: null,
        ], [
            'name'          => ['required', 'string'],
            'rt'            => ['nullable', 'sometimes', 'numeric'],
            'rw'            => ['nullable', 'sometimes', 'numeric'],
            'province_id'   => ['nullable'],
            'regency_id'    => ['nullable'],
            'district_id'   => ['nullable'],
            'village_id'    => ['nullable'],
        ], [
            'required'  => ':attribute wajib diisi.',
            'string'    => ':attribute harus berupa string.',
            'numeric'   => ':attribute harus berupa angka.',
        ], [
            'name'          => 'Nama Dasawisma',
            'rt'            => 'RT',
            'rw'            => 'RW',
        ]);

        $validateData = $validator->validate();

        try {
            if ($validator->passes()) {
                $validateData['name'] = str($this->name)->title();
                $validateData['slug'] = str($this->name)->slug();
            }

            $this->dasawisma->update($validateData);

            session()->flash('message', [
                'text' => 'Data Dasawisma ' . $this->dasawisma->name . ' berhasil diperbarui!',
                'type' => 'success',
            ]);

            $url = match (true) {
                session()->get('dasawisma_url') != url()->current() => session('dasawisma_url'),
                default => route('admin.data_input.dasawisma.index'),
            };

            return $this->redirect($url, true);
        } catch (\Exception $ex) {
            session()->flash('message', [
                'text' => 'Terjadi suatu kesalahan!!',
                'type' => 'danger',
            ]);

            return $this->redirect(route('admin.data_input.dasawisma.index'), true);
        }
    }
}
