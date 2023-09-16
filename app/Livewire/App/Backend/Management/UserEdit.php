<?php

namespace App\Livewire\App\Backend\Management;

use Closure;
use App\Models\Role;
use App\Models\User;
use App\Models\Regency;
use App\Models\Village;
use Livewire\Component;
use App\Models\District;
use App\Models\Province;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserEdit extends Component
{
    use WithFileUploads;

    public $roles, $provinces, $regencies, $districts, $villages;

    public ?User $user;
    public $oldProfilePicture, $name, $username, $email, $currentPassword, $phoneNumber, $roleId;
    public ?string $provinceId = null, $regencyId = null, $districtId = null, $villageId = null;

    public $newProfilePicture, $newPassword;

    public function mount(User $user)
    {
        $this->roles = Role::get(['id', 'name']);
        $this->provinces = Province::get(['id', 'name']);

        $this->user                 = $user;
        $this->oldProfilePicture    = $user->profile_picture;
        $this->name                 = $user->name;
        $this->username             = $user->username;
        $this->email                = $user->email;
        $this->phoneNumber          = $user->phone_number;
        $this->roleId               = $user->role_id;
        $this->provinceId           = $user->province_id;
        $this->regencyId            = $user->regency_id;
        $this->districtId           = $user->district_id;
        $this->villageId            = $user->village_id;

        if (!is_null($this->provinceId)) {
            $this->regencies = Regency::where('province_id', '=', $user->province_id)
                ->orderBy('name')
                ->get(['id', 'name']);
        }

        if (!is_null($this->regencyId)) {
            $this->districts = District::where('regency_id', '=', $user->regency_id)
                ->orderBy('name')
                ->get(['id', 'name']);
        }

        if (!is_null($this->districtId) || !is_null($this->villageId)) {
            $this->villages = Village::where('district_id', '=', $user->district_id)
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
        return view('livewire.app.backend.management.user-edit');
    }

    public function update()
    {
        $validated = Validator::make([
            'profile_picture'       => $this->newProfilePicture,
            'name'                  => $this->name,
            'username'              => $this->username,
            'email'                 => $this->email,
            'current_password'      => $this->currentPassword,
            'password'              => $this->newPassword,
            'phone_number'          => $this->phoneNumber,
            'role_id'               => $this->roleId,
            'province_id'           => $this->provinceId ?: null,
            'regency_id'            => $this->regencyId ?: null,
            'district_id'           => $this->districtId ?: null,
            'village_id'            => $this->villageId ?: null,
        ], [
            'profile_picture' => [
                'nullable', 'image', 'mimes:jpg,jpeg,png,svg,gif', 'max:2048',
                Rule::unique('users', 'profile_picture')->ignore($this->user->id)
            ],
            'name'      => ['required', 'string', 'min:3'],
            'username'  => [
                'required', 'string', 'min:3',
                Rule::unique('users', 'username')->ignore($this->user->id)
            ],
            'email'     => [
                'required', 'email',
                Rule::unique('users', 'email')->ignore($this->user->id)
            ],
            'current_password' => [
                'nullable', function (string $attribute, mixed $value, Closure $fail) {
                    if (!Hash::check($value, User::find($this->user->id)->password)) {
                        $fail(__(':attribute tidak cocok dengan password yang anda berikan.'));
                    }
                },
                'exclude'
            ],
            'password'  => [
                'nullable', Rule::requiredIf(!is_null($this->currentPassword)),
                function (string $attribute, mixed $value, Closure $fail) {
                    if (strcmp($this->currentPassword, $value) == 0) {
                        $fail(__(':attribute tidak boleh sama dengan password lama.'));
                    }
                }
            ],
            'phone_number'  => ['required', 'numeric'],
            'role_id'       => ['required'],
            'province_id'   => ['nullable'],
            'regency_id'    => ['nullable'],
            'district_id'   => ['nullable'],
            'village_id'    => ['nullable'],
        ], [
            'required'  => ':attribute wajib diisi.',
            'string'    => ':attribute harus berupa string.',
            'numeric'   => ':attribute harus berupa angka.',
            'image'     => ':attribute harus berupa gambar.',
            'mimes'     => ':attribute harus berformat .jpg,.jpeg,.png,.svg,.gif.',
            'min'       => ':attribute minimal :min karakter.',
            'max'       => 'Maksimal size :attribute 2 MB.',
            'unique'    => ':attribute sudah digunakan.',
        ], [
            'profile_picture'   => 'Foto Profil',
            'name'              => 'Nama',
            'username'          => 'Username',
            'email'             => 'Email',
            'current_password'  => 'Password Lama',
            'password'          => 'Password Baru',
            'phone_number'      => 'No. Telepon',
            'role_id'           => 'Role',
        ])->validate();

        try {
            $validated['password'] = match (true) {
                !empty($validated['password']) => Hash::make($validated['password']),
                default => $this->user->password,
            };

            if (!is_null($this->newProfilePicture)) {
                $pathImg = 'images/profiles';
                $dest = public_path("storage/$pathImg/");

                if (File::exists($dest . $this->oldProfilePicture)) {
                    File::delete($dest . $this->oldProfilePicture);
                }

                $newImg = $this->newProfilePicture->store($pathImg, 'public');
                $validated['profile_picture'] = str_replace("$pathImg/", '', $newImg);
            } else {
                $validated['profile_picture'] = $this->oldProfilePicture ?: NULL;
            }

            $this->user->update($validated);

            session()->flash('message', ['text' => 'Data User Berhasil diperbarui!', 'type' => 'success']);
        } catch (\Exception $ex) {
            session()->flash('message', ['text' => 'Something goes wrong!!', 'type' => 'error']);
        }

        $this->redirect(route('admin.management.user.index'), true);
    }
}
