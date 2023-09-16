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
                    @if (count($family_numbers))
                        <option value="{{ $family_numbers->total() }}">Semua</option>
                    @endif
                </select>
                data
            </label>
        </div>
        <div class="text-muted my-1 my-lg-0 ms-auto">
            <div class="input-icon">
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
                    <th rowspan="2">Dasawisma</th>
                    <th rowspan="2">Wilayah</th>
                    <th rowspan="2">Kepala Rumah Tangga</th>
                    <th colspan="7" class="text-center">Jumlah</th>
                    <th rowspan="2">Aksi</th>
                </tr>
                <tr>
                    <th>Balita</th>
                    <th>PUS</th>
                    <th>WUS</th>
                    <th>Orang Buta</th>
                    <th>Ibu Hamil</th>
                    <th>Ibu Menyusui</th>
                    <th>Lansia</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($family_numbers as $familyNumber)
                    <tr wire:key='{{ $familyNumber->id }}'>
                        <th class="text-muted">
                            {{ ($family_numbers->currentPage() - 1) * $family_numbers->perPage() + $loop->iteration }}
                        </th>
                        <td class="text-muted">{{ $familyNumber->dasawisma_name }}</td>
                        <td class="text-muted">{{ $familyNumber->area }}</td>
                        <td>{{ $familyNumber->kk_head }}</td>
                        <td>{{ $familyNumber->toddlers_number }}</td>
                        <td>{{ $familyNumber->pus_number }}</td>
                        <td>{{ $familyNumber->wus_number }}</td>
                        <td>{{ $familyNumber->blind_people_number }}</td>
                        <td>{{ $familyNumber->pregnant_women_number }}</td>
                        <td>{{ $familyNumber->breastfeeding_mother_number }}</td>
                        <td>{{ $familyNumber->elderly_number }}</td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a wire:navigate href="{{ route('admin.data_input.member.family_number.edit', [$familyNumber->kk_number]) }}"
                                    class="form-selectgroup-label bg-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit text-white" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                        <path d="M16 5l3 3"></path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center text-info">
                            {{ empty($family_numbers) ? 'Tidak ada data yang tersedia pada tabel ini!' : 'Tidak ditemukan data yang sesuai!' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer pb-1">
        @if (count($family_numbers))
            {{ $family_numbers->links() }}
        @endif
    </div>
</div>
