<?php

namespace App\Livewire\App\Auth\Profile;

use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class DetailForm extends Component
{
    public ?User $auth;

    public string $name, $username, $email, $phone_number;

    public function mount()
    {
        $this->auth = User::where('id', '=', auth()->id())->first([
            'id', 'name', 'username', 'email', 'phone_number',
        ]);

        $this->name = $this->auth->name;
        $this->username = $this->auth->username;
        $this->email = $this->auth->email;
        $this->phone_number = $this->auth->phone_number;
    }

    public function render()
    {
        return view('livewire.app.auth.profile.detail-form');
    }

    public function update()
    {
        $validated = Validator::make([
            'name'              => $this->name,
            'username'          => $this->username,
            'email'             => $this->email,
            'phone_number'      => $this->phone_number,
        ], [
            'name'          => ['required', 'string', 'min:3'],
            'username'      => ['required', 'string', 'min:3', Rule::unique('users', 'username')->ignore($this->auth->id)],
            'email'         => ['required', 'email', Rule::unique('users', 'email')->ignore($this->auth->id)],
            'phone_number'  => ['required', 'numeric'],
        ], [
            'required'  => ':attribute wajib diisi.',
            'string'    => ':attribute harus berupa string.',
            'numeric'   => ':attribute harus berupa angka.',
            'min'       => ':attribute minimal :min karakter.',
            'unique'    => ':attribute sudah digunakan.',
        ], [
            'name'          => 'Nama',
            'username'      => 'Username',
            'email'         => 'Email',
            'phone_number'  => 'No. Telepon',
        ])->validate();

        try {
            $this->auth->update($validated);

            session()->flash('message', ['text' => 'Detail Profil Berhasi di Perbarui!', 'type' => 'success']);
        } catch (\Exception $ex) {
            session()->flash('message', ['text' => 'Something goes wrong!!', 'type' => 'danger']);
        }

        return $this->redirect(route('admin.auth.profile'), true);
    }
}
