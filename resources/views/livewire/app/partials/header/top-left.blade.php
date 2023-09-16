<div class="d-flex align-items-center">
    <button class="navbar-toggler ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand d-none-navbar-horizontal pe-0 pe-md-3 ms-2 ms-lg-0">
        <a wire:navigate href="{{ url('/') }}">
            <img src="{{ asset('src/img/logo-favicon/logo-pkk.png') }}" alt="Dasawisma Logo" class="navbar-brand-image">
        </a>
        <span class="d-none d-lg-flex align-items-lg-center">{{ config('app.name') }}</span>
    </h1>
</div>
