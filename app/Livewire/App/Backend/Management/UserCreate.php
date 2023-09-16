<?php

namespace App\Livewire\App\Backend\Management;

use App\Models\Role;
use App\Models\User;
use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Province;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserCreate extends Component
{
    use WithFileUploads;

    public $roles, $provinces, $regencies, $districts, $villages;

    public $profilePicture, $name, $username, $email, $password, $passwordConfirmation, $phoneNumber, $roleId;
    public string $provinceId = '', $regencyId = '', $districtId = '', $villageId = '';

    public function mount()
    {
        $this->roles = Role::get(['id', 'name']);
        $this->provinces = Province::get(['id', 'name']);
    }

    public function updatedProvinceId($provinceId)
    {
        if ($this->provinceId !== '') {
            $this->regencies    = Regency::where('province_id', '=', $provinceId)
                ->orderBy('name')
                ->get(['id', 'name']);
            $this->districtId = $this->villageId = null;
        } else {
            $this->regencies = $this->districts = $this->villages = [];
        }
    }

    public function updatedRegencyId($regencyId)
    {
        if ($this->regencyId !== '') {
            $this->districts = District::where('regency_id', '=', $regencyId)
                ->orderBy('name')
                ->get(['id', 'name']);
            $this->villageId = null;
        } else {
            $this->districts = $this->villages = [];
        }
    }

    public function updatedDistrictId($districtId)
    {
        if ($this->districtId !== '') {
            $this->villages = Village::where('district_id', '=', $districtId)
                ->orderBy('name')
                ->get(['id', 'name']);
        } else {
            $this->villages = [];
        }
    }

    public function render()
    {
        return view('livewire.app.backend.management.user-create');
    }

    public function store()
    {
        $validator = Validator::make([
            'name'                  => $this->name,
            'username'              => $this->username,
            'email'                 => $this->email,
            'password'              => $this->password,
            'password_confirmation' => $this->passwordConfirmation,
            'phone_number'          => $this->phoneNumber,
            'profile_picture'       => $this->profilePicture,
            'role_id'               => $this->roleId,
            'province_id'           => $this->provinceId ?: null,
            'regency_id'            => $this->regencyId ?: null,
            'district_id'           => $this->districtId ?: null,
            'village_id'            => $this->villageId ?: null,
        ], [
            'name'                  => 'required|string|min:3',
            'username'              => 'required|string|min:3|unique:users,username',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:5',
            'password_confirmation' => 'required|min:5|same:password|exclude',
            'phone_number'          => 'required|numeric',
            'profile_picture'       => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048|unique:users,profile_picture',
            'role_id'               => 'required',
            'province_id'           => 'nullable',
            'regency_id'            => 'nullable',
            'district_id'           => 'nullable',
            'village_id'            => 'nullable',
        ], [
            'required'              => ':attribute wajib diisi.',
            'string'                => ':attribute harus berupa string.',
            'image'                 => ':attribute harus berupa gambar.',
            'numeric'               => ':attribute harus berupa angka.',
            'min'                   => ':attribute minimal :min karakter.',
            'profile_picture.max'   => 'Maksimal size :attribute 2 MB.',
            'mimes'                 => ':attribute harus berformat .jpg,.jpeg,.png,.svg,.gif.',
            'unique'                => ':attribute sudah digunakan.',
            'same'                  => ':attribute harus sama dengan password.',
        ], [
            'name'                  => 'Nama',
            'username'              => 'Username',
            'email'                 => 'Email',
            'password'              => 'Password',
            'password_confirmation' => 'Konfirmasi Password',
            'phone_number'          => 'No. Telepon',
            'profile_picture'       => 'Foto Profil',
            'role_id'               => 'Role',
        ]);

        $validData = $validator->validate();

        try {
            if (!is_null($validData['profile_picture'])) {
                $pathImg = 'images/profiles';
                $imageName = $this->profilePicture->store($pathImg, 'public');
                $validData['profile_picture'] = str_replace("$pathImg/", '', $imageName);
            }

            if ($validator->passes()) {
                $validData['name'] = str($validData['name'])->title();
                $validData['password'] = Hash::make($validData['password']);
            }

            User::create($validData);

            session()->flash('message', ['text' => 'User baru berhasil ditambahkan!', 'type' => 'success']);
        } catch (\Exception $ex) {
            session()->flash('message', ['text' => 'Something goes wrong!!', 'type' => 'danger']);
        }

        return $this->redirect(route('admin.management.user.index'), true);
    }
}
