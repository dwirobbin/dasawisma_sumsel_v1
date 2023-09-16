<div class="sticky-top">
    <header class="layout-fluid navbar navbar-expand-md d-print-none">
        <div class="container-xl px-0 px-md-3 d-flex ">
            {{-- top left --}}
            @livewire('app.partials.header.top-left')

            {{-- top right --}}
            @livewire('app.partials.header.top-right')

            {{-- navigation --}}
            @livewire('app.partials.header.navigation')
        </div>
    </header>
</div>
