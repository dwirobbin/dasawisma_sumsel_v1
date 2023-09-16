<div class="navbar-nav flex-row order-md-last">
    @guest
        <div class="nav-item d-none d-md-flex me-3">
            <div class="btn-list">
                <a wire:navigate href="{{ route('admin.auth.login.get') }}" class="btn" rel="noreferrer">
                    Login
                </a>
            </div>
        </div>
    @endguest
    <div class="d-flex">
        <a wire:navigate href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
            data-bs-placement="bottom">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
            </svg>
        </a>
        <a wire:navigate href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
            data-bs-placement="bottom">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
            </svg>
        </a>
    </div>
    @auth
        <div class="nav-item dropdown me-2 me-lg-0" x-data="{ open: false }" x-on:click.outside="open = false">
            <a x-on:click="open = !open" :class="{ 'show': open == true }" class="nav-link d-flex lh-1 text-reset p-0 cursor-pointer">
                <img src="{{ !is_null($auth->profile_picture) ? asset('storage/images/profiles/' . $auth->profile_picture) : asset('src/img/auth/profile_default.png') }}"
                    id="profileImage" class="avatar avatar-sm">
                <div class="d-none d-xl-block ps-2">
                    <div>{{ $auth->name }}</div>
                    <div class="mt-1 small text-muted">{{ $auth->username }}</div>
                </div>
            </a>
            <div x-show="open" :class="{ 'show': open == true }" class="dropdown-menu dropdown-menu-end dropdown-menu-arrow"
                :data-bs-popper="{ 'static': open == true }">
                @if (request()->routeIs('home'))
                    <a wire:navigate href="{{ route('admin.home.index') }}" class="dropdown-item">Dashboard</a>
                @elseif (request()->routeIs('admin.*'))
                    <a wire:navigate href="{{ route('admin.auth.profile') }}" x-ref="profileLink" class="dropdown-item">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a wire:navigate href="{{ route('home') }}" class="dropdown-item">Home</a>
                @endif
                <div class="dropdown-divider"></div>
                <a wire:click='logoutHandler' class="dropdown-item" role="button">Logout</a>
            </div>
        </div>
    @endauth
</div>
