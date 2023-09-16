<div>
    <form class="card" wire:submit.prevent="update" method="post" autocomplete="off">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Edit Angota Keluarga</h2>

            <div class="row mb-3">
                <div class="col-4">
                    <label class="form-label required">Dasawisma</label>
                    <div>
                        <select wire:model='dasawismaId' class="form-select @error('dasawisma_id') is-invalid @enderror">
                            <option value='' selected>---Pilih Dasawisma---</option>
                            @isset($dasawismas)
                                @foreach ($dasawismas as $dasawisma)
                                    <option value="{{ $dasawisma->id }}">
                                        {{ $dasawisma->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @error('dasawisma_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-4">
                    <label class="form-label required">No. KK</label>
                    <div>
                        <input type="text" wire:model='kkNumber' class="form-control @error('kk_number') is-invalid @enderror"
                            placeholder="No. KK...">
                        @error('kk_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-4">
                    <label class="form-label required">Nama Kepala Keluarga</label>
                    <div>
                        <input type="text" wire:model.live='kkHead' class="form-control @error('kk_head') is-invalid @enderror"
                            placeholder="Nama Kepala Keluarga...">
                        @error('kk_head')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped table-hover">
                        <thead>
                            <tr>
                                <th rowspan="2">
                                    <button type="button" class="btn btn-outline-primary" wire:click='addFamilyMember'>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 5l0 14"></path>
                                            <path d="M5 12l14 0"></path>
                                        </svg>
                                    </button>
                                </th>
                                <th rowspan="2">No. NIK</th>
                                <th rowspan="2">Nama Lengkap <label class="text-danger">*</label></th>
                                <th rowspan="2">Tgl Lahir <label class="text-danger">*</label></th>
                                <th colspan="2" class="text-center">Status <label class="text-danger">*</label></th>
                                <th rowspan="2">Jenis Kelamin <label class="text-danger">*</label></th>
                                <th rowspan="2">Pendidikan Terakhir <label class="text-danger">*</label></th>
                                <th rowspan="2">Pekerjaan</th>
                            </tr>
                            <tr>
                                <th>Di Keluarga</th>
                                <th>Pernikahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($familyMembers as $index => $familyMember)
                                <tr>
                                    <td>
                                        @if (!isset($familyMember['family_member_count']))
                                            <button type="button" class="btn btn-outline-danger"
                                                wire:click='removeFamilyMember({{ $index }})'>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M4 7l16 0"></path>
                                                    <path d="M10 11l0 6"></path>
                                                    <path d="M14 11l0 6"></path>
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="text" wire:model='familyMembers.{{ $index }}.nik_number'
                                            class="form-control @error('family_members.' . $index . '.nik_number') is-invalid @enderror"
                                            placeholder="No. NIK..." style="width: 10rem">
                                        @error('family_members.' . $index . '.nik_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" wire:model.live='familyMembers.{{ $index }}.name'
                                            class="form-control @error('family_members.' . $index . '.name') is-invalid @enderror"
                                            placeholder="Nama Lengkap..." style="width: 12rem">
                                        @error('family_members.' . $index . '.name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="date" wire:model='familyMembers.{{ $index }}.birth_date'
                                            class="form-control @error('family_members.' . $index . '.birth_date') is-invalid @enderror"
                                            placeholder="Tgl. Lahir" style="width: 11rem">
                                        @error('family_members.' . $index . '.birth_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <select wire:model='familyMembers.{{ $index }}.status'
                                            class="form-select @error('family_members.' . $index . '.status') is-invalid @enderror"
                                            style="width: 12rem" @disabled($loop->first)>
                                            <option value="">Status di Keluarga</option>
                                            <option value="Kepala Keluarga">Kepala Keluarga</option>
                                            <option value="Istri">Istri</option>
                                            <option value="Anak">Anak</option>
                                            <option value="Keluarga">Keluarga</option>
                                            <option value="Orang Tua">Orang Tua</option>
                                        </select>
                                        @error('family_members.' . $index . '.status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <select wire:model='familyMembers.{{ $index }}.marital_status'
                                            class="form-select @error('family_members.' . $index . '.marital_status') is-invalid @enderror"
                                            style="width: 12rem">
                                            <option value="">Status Pernikahan</option>
                                            <option value="Kawin">Kawin</option>
                                            <option value="Janda">Janda</option>
                                            <option value="Duda">Duda</option>
                                            <option value="Belum Kawin">Belum Kawin</option>
                                        </select>
                                        @error('family_members.' . $index . '.marital_status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <select wire:model='familyMembers.{{ $index }}.gender'
                                            class="form-select @error('family_members.' . $index . '.gender') is-invalid @enderror"
                                            style="width: 11rem">
                                            <option value="">Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                        @error('family_members.' . $index . '.gender')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <select wire:model='familyMembers.{{ $index }}.last_education'
                                            class="form-select @error('family_members.' . $index . '.last_education') is-invalid @enderror"
                                            style="width: 12rem">
                                            <option value="">Pendidikan Terakhir</option>
                                            <option value="TK/PAUD">TK/PAUD</option>
                                            <option value="SD/MI">SD/MI</option>
                                            <option value="SLTP/SMP/MTS">SLTP/SMP/MTS</option>
                                            <option value="SLTA/SMA/MA/SMK">SLTA/SMA/MA/SMK</option>
                                            <option value="Diploma">Diploma</option>
                                            <option value="S1">S1</option>
                                            <option value="S2">S2</option>
                                            <option value="S3">S3</option>
                                            <option value="Belum/Tidak Sekolah">Belum/Tidak Sekolah</option>
                                        </select>
                                        @error('family_members.' . $index . '.last_education')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" wire:model='familyMembers.{{ $index }}.profession'
                                            class="form-control @error('family_members.' . $index . '.profession') is-invalid @enderror"
                                            placeholder="Pekerjaan..." style="width: 12rem">
                                        @error('family_members.' . $index . '.profession')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-footer d-flex justify-content-between">
                <a wire:navigate href="{{ route('admin.data_input.member.index') }}" class="btn btn-secondary me-auto">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>
