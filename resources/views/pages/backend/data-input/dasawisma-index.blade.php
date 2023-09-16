@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        @if (session()->has('message'))
            <div class="alert alert-important alert-{{ session('message')['type'] }} alert-dismissible mt-3 mb-0 mx-3" role="alert">
                <div>{{ session('message')['text'] }}</div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif

        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col-4">
                        <h2 class="page-title">Dasawisma</h2>
                    </div>
                    <div class="col-auto ms-auto">
                        <a wire:navigate href="{{ route('admin.data_input.dasawisma.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 5l0 14"></path>
                                <path d="M5 12l14 0"></path>
                            </svg>
                            New Dasawisma
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    @livewire('app.backend.data-input.dasawisma-index', ['lazy' => true])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $("document").ready(function() {
            setTimeout(function() {
                $("div.alert").remove();
            }, 3000);

        });

        function deleteConfirm(id, name) {
            return Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi hapus Dasawisma!',
                html: `Apakah anda ingin menghapus Dasawisma ini: <b>${name}</b> ?`,
                showCloseButton: true,
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false,
                customClass: {
                    cancelButton: 'order-1',
                    confirmButton: 'order-2',
                },
            }).then(function(result) {
                if (result.isConfirmed) {
                    Livewire.dispatch('dasawisma-deleted', {
                        dasawismaId: id
                    })
                }
            });
        }
    </script>
@endpush
