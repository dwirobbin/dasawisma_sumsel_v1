<?php

namespace App\Livewire\App\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Validator;

class Login extends Component
{
    public ?string $loginId = NULL;
    public ?string $password = NULL;

    public ?string $returnUrl = NULL;

    public function mount(): void
    {
        $this->returnUrl = request()->get('return-url');
    }

    public function render(): View
    {
        return view('livewire.app.auth.login');
    }

    public function loginHandler()
    {
        $fieldType = filter_var($this->loginId, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (empty($this->loginId)) {
            $rules = ['login_id'   => 'required', 'password'  => 'required|min:5'];
            $messages = [
                'required'  => ':attribute wajib diisi.',
                'exists'    => ':attribute tidak terdaftar di database.',
                'min'       => ':attribute minimal harus  :min karakter.'
            ];
            $attrs = ['login_id'   => 'Email atau Username', 'password'  => 'Password'];
        } else if ($fieldType === 'email') {
            $rules = [
                'login_id'   => 'required|email|exists:users,email',
                'password'  => 'required|min:5',
            ];
            $messages = [
                'required'  => ':attribute wajib diisi.',
                'email'     => 'Format :attribute tidak valid.',
                'exists'    => ':attribute tidak terdaftar di database.',
                'min'       => ':attribute minimal harus  :min karakter.'
            ];
            $attrs = ['login_id'   => 'Alamat email', 'password'  => 'Password'];
        } else if ($fieldType === 'username') {
            $rules = [
                'login_id'   => 'required|exists:users,username',
                'password'  => 'required|min:5',
            ];
            $messages = [
                'required'  => ':attribute wajib diisi.',
                'exists'    => ':attribute tidak terdaftar di database.',
                'min'       => ':attribute minimal harus  :min karakter.'
            ];
            $attrs = ['login_id'   => 'Username', 'password'  => 'Password'];
        }

        $validateData = Validator::make(
            ['login_id' => $this->loginId, 'password' => $this->password],
            $rules,
            $messages,
            $attrs,
        )->validate();

        $credential = [
            $fieldType => $validateData['login_id'],
            'password' => $validateData['password'],
        ];

        if (auth()->attempt($credential)) {
            $userIsActive = User::where($fieldType, $validateData['login_id'])->value('is_active');
            if ($userIsActive) {
                $url = $this->returnUrl ?? route('home');

                return $this->redirect($url, true);
            }

            auth()->logout();
            session()->flash('fail', 'Akun anda telah dinonaktifkan!!');
        }

        session()->flash('fail', 'Gagal Login!!');
    }
}
