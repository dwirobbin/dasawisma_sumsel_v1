<div class="row align-items-center" x-data="{ imagePreview: $wire.profilePicture }">
    <div class="col-auto">
        <img class="avatar avatar-md" x-bind:src="imagePreview">
    </div>
    <div class="col">
        <h2 class="page-title">{{ $auth->name }}</h2>
        <div class="page-subtitle">
            <div class="row">
                <div class="col-auto">
                    <a href="#" class="text-reset text-decoration-none" onclick="event.preventDefault()">
                        {{ $auth->username }} | {{ $auth->email }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @if ($auth->role_id !== 3)
        <div class="col-auto">
            <input type="file" wire:model='profilePicture' class="d-none" x-ref="image" accept=".png,.jpg,.jpeg,.svg,.gif">
            <a x-on:click="$refs.image.click()" class="btn btn-primary">
                Ubah Foto Profil
            </a>
        </div>
        @error('profile_picture')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    @endif
</div>
