<form wire:submit.prevent='changePassword' method="post">
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Password Saat Ini</label>
            <input type="password" wire:model='current_password' class="form-control @error('current_password') is-invalid @enderror"
                placeholder="Password Saat Ini...">
            @error('current_password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" wire:model='password' class="form-control @error('password') is-invalid @enderror"
                placeholder="Password Baru...">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" wire:model='password_confirmation' class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="Konfirmasi Password...">
            @error('password_confirmation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>
