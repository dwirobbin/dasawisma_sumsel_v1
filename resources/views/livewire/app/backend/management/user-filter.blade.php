<div class="d-flex flex-wrap justify-content-center pb-3">
    <div class="text-muted my-1 my-lg-0">
        <label>
            Lihat
            <select class="d-inline-block form-select w-auto" wire:model.live='perPage' wire:change='filter'>
                @foreach ($per_pages as $item)
                    <option value="{{ $item }}">
                        @if ($loop->last)
                            Semua
                        @else
                            {{ $item }}
                        @endif
                    </option>
                @endforeach
            </select>
            data
        </label>
    </div>
    <div class="text-muted mx-auto my-1 my-lg-0">
        <label>
            Status Akun
            <select class="d-inline-block form-select w-auto" wire:model='isActive' wire:change='filter'>
                <option value="">Semua</option>
                @foreach ($statuses as $key => $item)
                    <option value="{{ $item }}">{{ $key }}</option>
                @endforeach
            </select>
        </label>
    </div>
    <div class="text-muted my-1 my-lg-0">
        <div class="input-icon">
            <input type="text" wire:model='search' wire:keyup.debounce='filter' class="form-control" placeholder="Cari...">
            <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                    <path d="M21 21l-6 -6" />
                </svg>
            </span>
        </div>
    </div>
</div>
