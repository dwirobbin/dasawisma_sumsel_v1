<form wire:submit.prevent='update' method="post">
    <div class="row">
        <div class="col-md-3 mb-3">
            <label class="form-label required">Name</label>
            <input type="text" wire:model='name' class="form-control @error('name') is-invalid @enderror" placeholder="Nama...">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label required">Username</label>
            <input type="text" wire:model='username' class="form-control @error('username') is-invalid @enderror" placeholder="Username...">
            @error('username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label required">Email</label>
            <input type="email" wire:model='email' class="form-control @error('email') is-invalid @enderror" placeholder="Email...">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label required">No. Telp</label>
            <input type="tel" wire:model='phone_number' class="form-control @error('phone_number') is-invalid @enderror"
                placeholder="No. Telp...">
            @error('phone_number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>
