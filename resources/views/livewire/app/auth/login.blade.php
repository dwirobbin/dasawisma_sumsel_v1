<div>
    @if (session()->has('success'))
        <div class="alert alert-important alert-success alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                        <path d="M9 12l2 2l4 -4"></path>
                    </svg>
                </div>
                <div>{{ session()->get('success') }}</div>
            </div>
            <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    @endif

    @if (session()->has('fail'))
        <div class="alert alert-important alert-danger alert-dismissible" role="alert">
            <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="12" cy="12" r="9"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <div>{{ session()->get('fail') }}</div>
            </div>
            <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
    @endif

    <form wire:submit.prevent='loginHandler' class="card card-md" method="post" autocomplete="off">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Masuk ke akun Anda</h2>
            <div class="mb-3">
                <label class="form-label required">Email atau Username</label>
                <input type="text" wire:model='loginId' class="form-control @error('login_id') is-invalid @enderror"
                    placeholder="Email atau Username Anda..." autofocus>
                @error('login_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-2">
                <label class="form-label required">
                    Password
                    <span class="form-label-description">
                        <a href="{{ route('admin.auth.forgot_password.get') }}">Lupa Password</a>
                    </span>
                </label>
                <div class="input-group input-group-flat" x-data="{ isVisible: false }">
                    <input @visibility.window="$el.type = ($el.type == 'password') ? 'text' : 'password'" type="password" wire:model='password'
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password Anda...">
                    <span class="input-group-text">
                        <a @click="$dispatch('visibility'); isVisible = !isVisible;" href="#" class="link-secondary"
                            data-bs-toggle="tooltip">
                            <div x-show='!isVisible'>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                </svg>
                            </div>

                            <div x-show='isVisible'>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-off" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828"></path>
                                    <path
                                        d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87">
                                    </path>
                                    <path d="M3 3l18 18"></path>
                                </svg>
                            </div>
                        </a>
                    </span>
                </div>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </div>
        </div>
    </form>
</div>
