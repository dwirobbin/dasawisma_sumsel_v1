<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>{{ $title }} - {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('src/img/logo-favicon/default-favicon.ico') }}" type="image/x-icon">

    <!-- CSS files -->
    <link href="{{ asset('src/css/tabler.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('src/css/tabler-vendors.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('src/css/inter/inter.css') }}" rel="stylesheet">
    <link href="{{ asset('src/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />

    @stack('styles')
    @livewireStyles
</head>

<body class="d-flex flex-column">
    <script src="{{ asset('src/js/demo-theme.min.js') }}"></script>

    <div class="page {{ $page ?? 'layout-fluid' }}">
        @include('layouts.partials.header')

        @yield('content')

        @include('layouts.partials.footer')
    </div>

    <!-- Libs JS -->
    <script src="{{ asset('src/libs/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('src/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('src/js/tabler.min.js') }}"></script>

    @stack('scripts')
    @livewireChartsScripts
    @livewireScripts

    <script>
        $('[x-ref="profileLink"]').on('click', function() {
            localStorage.setItem('_x_currentTabProfile', '"tabsProfileDetail"');
        });
    </script>
</body>

</html>
