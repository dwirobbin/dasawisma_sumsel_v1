<?php

namespace App\Livewire\App\Auth\Profile;

use Closure;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordForm extends Component
{
    public ?User $auth;

    public string $current_password = '', $password = '', $password_confirmation = '';

    public function mount()
    {
        $this->auth = User::where('id', '=', auth()->id())->first(['id', 'password']);
    }

    public function render()
    {
        return view('livewire.app.auth.profile.change-password-form');
    }

    public function changePassword()
    {
        $validated = Validator::make([
            'current_password'      => $this->current_password,
            'password'              => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ], [
            'current_password'  => [
                'required', function (string $attribute, mixed $value, Closure $fail) {
                    if (!Hash::check($value, $this->auth->password)) {
                        return $fail(__(':attribute tidak cocok dengan password yang Anda berikan.'));
                    }
                },
            ],
            'password' => [
                'required', 'min:5', function (string $attribute, mixed $value, Closure $fail) {
                    if (strcmp($this->current_password, $value) == 0) {
                        $fail(__(':attribute tidak boleh sama dengan password saat ini.'));
                    }
                }
            ],
            'password_confirmation'  => ['required', 'min:5', 'same:password'],
        ], [
            'required'  => ':attribute wajib diisi.',
            'min'       => ':attribute minimal :min karakter.',
            'same'      => ':attribute harus sama dengan Password Baru.'
        ], [
            'current_password'      => 'Password Saat Ini',
            'password'              => 'Password Baru',
            'password_confirmation' => 'Konfirmasi Password Baru',
        ])->validate();

        try {
            $this->auth->update(['password' => Hash::make($validated['password'])]);

            session()->flash('message', ['text' => 'Password anda telah berhasil diperbarui!', 'type' => 'success']);
        } catch (\Exception $ex) {
            session()->flash('message', ['text' => 'Something goes wrong!!', 'type' => 'danger']);
        }

        return $this->redirect(route('admin.auth.profile'), true);
    }
}
