<?php

namespace App\Livewire\App\Auth\Profile;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class Picture extends Component
{
    use WithFileUploads;

    public User $auth;

    public $profilePicture = null;

    public function mount(): void
    {
        $this->auth = User::where('id', '=', auth()->id())->first([
            'id', 'profile_picture', 'name', 'username', 'email',
        ]);

        $this->profilePicture = !is_null($this->auth->profile_picture)
            ? asset('storage/images/profiles/' . $this->auth->profile_picture)
            : asset('src/img/auth/profile_default.png');
    }

    public function updatedProfilePicture()
    {
        $validated = Validator::make([
            'profile_picture'   => $this->profilePicture,
        ], [
            'profile_picture'   => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048|unique:users,profile_picture,' . $this->auth->id,
        ], [
            'image'     => ':attribute harus berupa gambar.',
            'mimes'     => ':attribute harus berformat .jpg,.jpeg,.png,.svg,.gif.',
            'max'       => 'Maksimal size :attribute 2 MB.',
            'unique'    => ':attribute sudah digunakan.',
        ], [
            'profile_picture' => 'Foto Profil',
        ])->validate();

        try {
            if (!is_null($validated['profile_picture'])) {
                $pathImg = 'images/profiles';
                $dest = public_path("storage/$pathImg/");

                if (File::exists($dest . $this->auth->profile_picture)) {
                    File::delete($dest . $this->auth->profile_picture);
                }

                $newImg = $this->profilePicture->store($pathImg, 'public');
                $validated['profile_picture'] = str_replace("$pathImg/", '', $newImg);
            }

            $this->auth->update($validated ?? $this->auth->profile_picture);

            session()->flash('message', ['text' => 'Foto Profil Berhasil diperbarui!', 'type' => 'success']);
        } catch (\Exception $e) {
            session()->flash('message', ['text' => 'Something goes wrong!!', 'type' => 'danger']);
        }

        return $this->redirect(route('admin.auth.profile'), true);
    }

    public function render()
    {
        return view('livewire.app.auth.profile.picture');
    }
}
