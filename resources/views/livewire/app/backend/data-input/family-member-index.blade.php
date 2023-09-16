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
                    <th rowspan="2">No. KK</th>
                    <th rowspan="2">Nama</th>
                    <th rowspan="2">NIK</th>
                    <th rowspan="2">Tgl Lahir</th>
                    <th colspan="2" class="text-center">Status</th>
                    <th rowspan="2">Jenis Kelamin</th>
                    <th rowspan="2">Pendidikan Terakhir</th>
                    <th rowspan="2">Pekerjaan</th>
                    <th rowspan="2">Aksi</th>
                </tr>
                <tr>
                    <th>di Keluarga</th>
                    <th>Kawin</th>
                </tr>
            </thead>
            <tbody>
                @php($i = $family_members->perPage() * $family_members->currentPage() - ($family_members->perPage() - 1))

                @forelse ($family_members as $kk_number => $familyMembers_list)
                    @foreach ($familyMembers_list as $familyMember)
                        <tr class="text-nowrap" wire:key='{{ $familyMember->id }}'>
                            <th class="text-muted">{{ $i }}</th>
                            <td class="text-muted">{{ $familyMember->dasawisma_name }}</td>
                            <td class="text-muted">{{ $familyMember->area }}</td>
                            <td>{{ $familyMember->kk_number }}</td>
                            <td>{{ $familyMember->name }}</td>
                            <td>{{ $familyMember->nik_number }}</td>
                            <td>{{ $familyMember->birth_date }}</td>
                            <td>{{ $familyMember->status }}</td>
                            <td>{{ $familyMember->marital_status }}</td>
                            <td>{{ $familyMember->gender }}</td>
                            <td>{{ $familyMember->last_education }}</td>
                            <td>{{ $familyMember->profession }}</td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a wire:navigate
                                        href="{{ route('admin.data_input.member.family_member.edit', [$familyMember->kk_number]) }}"
                                        class="form-selectgroup-label bg-warning">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit text-white"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                            <path d="M16 5l3 3"></path>
                                        </svg>
                                    </a>
                                    @if ($familyMember->family_members_count > 1 && (!$loop->first || $familyMember->status != 'Kepala Keluarga'))
                                        <a x-on:click="familyMemberDeleteConfirm({{ $familyMember->id }}, '{{ $familyMember->name }}')"
                                            class="form-selectgroup-label bg-danger" role="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash text-white"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 7l16 0"></path>
                                                <path d="M10 11l0 6"></path>
                                                <path d="M14 11l0 6"></path>
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @php($i++)
                    @endforeach
                @empty
                    <tr>
                        <td colspan="13" class="text-center text-info">
                            {{ empty($family_members) ? 'Tidak ada data yang tersedia pada tabel ini!' : 'Tidak ditemukan data yang sesuai!' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer pb-1">
        @if (count($family_members))
            {{ $family_members->links() }}
        @endif
    </div>
</div>
