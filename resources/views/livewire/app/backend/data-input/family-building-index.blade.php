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
                    @if (count($family_buildings))
                        <option value="{{ $family_buildings->total() }}">Semua</option>
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
                    <th rowspan="2">Makanan Pokok</th>
                    <th rowspan="2">Sumber Air Keluarga</th>
                    <th colspan="3" class="text-center">Mempunyai</th>
                    <th rowspan="2">Menempel Stiker P4K</th>
                    <th rowspan="2">Kriteria Rumah</th>
                    <th rowspan="2" class="w-1">Aksi</th>
                </tr>
                <tr>
                    <th>Jamban</th>
                    <th>TPS</th>
                    <th>SPAL</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($family_buildings as $familyBuilding)
                    <tr wire:key='{{ $familyBuilding->id }}' class="text-nowrap">
                        <th class="text-muted">
                            {{ ($family_buildings->currentPage() - 1) * $family_buildings->perPage() + $loop->iteration }}
                        </th>
                        <td class="text-muted">{{ $familyBuilding->dasawisma_name }}</td>
                        <td class="text-muted">{{ $familyBuilding->area }}</td>
                        <td>{{ $familyBuilding->kk_head }}</td>
                        <td>{{ $familyBuilding->staple_food }}</td>
                        <td>{{ $familyBuilding->water_src }}</td>
                        <td>{{ $familyBuilding->have_toilet }}</td>
                        <td>{{ $familyBuilding->have_landfill }}</td>
                        <td>{{ $familyBuilding->have_sewerage }}</td>
                        <td>{{ $familyBuilding->pasting_p4k_sticker }}</td>
                        <td>{{ $familyBuilding->house_criteria }}</td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a wire:navigate
                                    href="{{ route('admin.data_input.member.family_building.edit', [$familyBuilding->kk_number]) }}"
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
                            {{ empty($family_buildings) ? 'Tidak ada data yang tersedia pada tabel ini!' : 'Tidak ditemukan data yang sesuai!' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer pb-1">
        @if (count($family_buildings))
            {{ $family_buildings->links() }}
        @endif
    </div>
</div>
