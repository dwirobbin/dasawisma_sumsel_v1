<div>
    <div class="card-header py-2 d-flex flex-wrap justify-content-center">
        <div class="text-muted my-1 my-lg-0">
            <label>
                Lihat
                <select class="d-inline-block form-select w-auto" wire:model.live='perPage'>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    @if (count($data))
                        <option value="{{ $data->total() }}">Semua</option>
                    @endif
                </select>
                data
            </label>
        </div>
        <div class="text-muted my-1 my-lg-0 ms-auto">
            <div class="input-icon">
                <span class="input-icon-addon my-2 ms-2" wire:loading.delay wire:target='search'>
                    <div class="spinner-border spinner-border-sm text-muted" role="status"></div>
                </span>
                <input type="text" wire:model.live='search' class="form-control" placeholder="Cari...">
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

    <div class="table-responsive">
        <table class="table table-vcenter card-table table-striped table-hover">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">
                        @if (str_contains($currentUrl, '/index') || (str_contains($currentUrl, '/area') && strlen(substr(strrchr($currentUrl, '/'), 1)) != 10))
                            Wilayah
                        @elseif (str_contains($currentUrl, '/area') && strlen(substr(strrchr($currentUrl, '/'), 1)) == 10)
                            Dasawisma
                        @else
                            Nama Kepala Keluarga
                        @endif
                    </th>
                    <th colspan="7" class="text-center">Jumlah</th>
                </tr>
                <tr>
                    <th>Balita</th>
                    <th>Psngan Usia Subur</th>
                    <th>Wan. Usia Subur</th>
                    <th>Org Buta</th>
                    <th>Ibu Hamil</th>
                    <th>Ibu Menyusui</th>
                    <th>Lansia</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr class="text-nowrap" wire:key='{{ $item->id }}'>
                        <th class="text-muted">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                        </th>
                        <td>
                            @if (str_contains($currentUrl, '/index') || (strlen((int) $item->id) == 4 || strlen((int) $item->id) == 7 || strlen((int) $item->id) == 10))
                                <a href="{{ route('admin.data_recap.family_numbers.show_area', ['code' => $item->id]) }}">
                                    {{ $item->name }}
                                </a>
                            @elseif(isset($item->slug))
                                <a href="{{ route('admin.data_recap.family_numbers.show_dasawisma', ['slug' => $item->slug]) }}">
                                    {{ $item->name }}
                                </a>
                            @else
                                <a>
                                    {{ $item->name }}
                                </a>
                            @endif
                        </td>
                        <td>{{ number_format($item->toddlers_sum, 0, '', '.') }}</td>
                        <td>{{ number_format($item->pus_sum, 0, '', '.') }}</td>
                        <td>{{ number_format($item->wus_sum, 0, '', '.') }}</td>
                        <td>{{ number_format($item->blind_peoples_sum, 0, '', '.') }}</td>
                        <td>{{ number_format($item->pregnant_womens_sum, 0, '', '.') }}</td>
                        <td>{{ number_format($item->breastfeeding_mothers_sum, 0, '', '.') }}</td>
                        <td>{{ number_format($item->elderlies_sum, 0, '', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-info">
                            {{ empty($data) ? 'Tidak ada data yang tersedia pada tabel ini!' : 'Tidak ditemukan data yang sesuai!' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer pb-1">
        @if (count($data))
            {{ $data->links() }}
        @endif
    </div>
</div>
