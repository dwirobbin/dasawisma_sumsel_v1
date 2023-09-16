<div>
    <form class="card" wire:submit.prevent="submitForm" method="post" autocomplete="off">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Tambah Anggota</h2>

            <ul class="steps steps-green steps-counter my-4">
                <li class="step-item {{ $currentStep == 1 ? 'active' : '' }}"></li>
                <li class="step-item {{ $currentStep == 2 ? 'active' : '' }}"></li>
                <li class="step-item {{ $currentStep == 3 ? 'active' : '' }}"></li>
                <li class="step-item {{ $currentStep == 4 ? 'active' : '' }}"></li>
                <li class="step-item {{ $currentStep == 5 ? 'active' : '' }}"></li>
            </ul>

            {{-- Step 1 --}}
            <div class="{{ $currentStep == 1 ? '' : 'd-none' }}">
                <div class="row mb-3">
                    <label class="col-3 form-label required">Dasawisma</label>
                    <div class="col">
                        <select wire:model.blur='dasawismaId' class="form-select @error('dasawisma_id') is-invalid @enderror">
                            <option value='' selected>---Pilih Dasawisma---</option>
                            @if (!is_null($dasawismas))
                                @foreach ($dasawismas as $dasawisma)
                                    <option value="{{ $dasawisma->id }}">
                                        {{ $dasawisma->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('dasawisma_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-3 form-label required">No. KK</label>
                    <div class="col">
                        <input type="text" wire:model.blur='kkNumber' class="form-control @error('kk_number') is-invalid @enderror"
                            placeholder="No. KK...">
                        @error('kk_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-3 form-label required">Nama Kepala Keluarga</label>
                    <div class="col">
                        <input type="text" wire:model.live='kkHead' class="form-control @error('kk_head') is-invalid @enderror"
                            placeholder="Nama Kepala Keluarga...">
                        @error('kk_head')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-footer d-flex justify-content-between">
                    <a wire:navigate href="{{ route('admin.data_input.dasawisma.index') }}" class="btn btn-danger me-auto">
                        Batal
                    </a>
                    <button type="button" wire:click="firstStepSubmit" class="btn btn-primary">
                        Selanjutnya
                    </button>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="{{ $currentStep == 2 ? '' : 'd-none' }}">
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label pt-0 required">Sumber Air Keluarga</label>
                        <div class="col d-flex flex-row justify-content-between">
                            <label class="form-check" role="button">
                                <input type="checkbox" wire:model.blur='waterSrc' class="form-check-input" value="PDAM" role="button">
                                <span class="form-check-label text-muted">PDAM</span>
                            </label>
                            <label class="form-check" role="button">
                                <input type="checkbox" wire:model.blur='waterSrc' class="form-check-input" value="Sumur" role="button">
                                <span class="form-check-label text-muted">Sumur</span>
                            </label>
                            <label class="form-check" role="button">
                                <input type="checkbox" wire:model.blur='waterSrc' class="form-check-input" value="Sungai" role="button">
                                <span class="form-check-label text-muted">Sungai</span>
                            </label>
                            <label class="form-check" role="button">
                                <input type="checkbox" wire:model.blur='waterSrc' class="form-check-input" value="Lainnya" role="button">
                                <span class="form-check-label text-muted">Lainnya</span>
                            </label>
                        </div>
                        @error('water_src')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 mb-3">
                    <div class="col">
                        <div class="row mb-3">
                            <label class="form-label pt-0 required">Makanan Pokok</label>
                            <div>
                                <label class="form-check form-check-inline" role="button">
                                    <input type="radio" name="staple_food" wire:model.blur="stapleFood" class="form-check-input" value="Beras"
                                        role="button">
                                    <span class="form-check-label text-muted">Beras</span>
                                </label>
                                <label class="form-check form-check-inline" role="button">
                                    <input type="radio" name="staple_food" wire:model.blur="stapleFood" class="form-check-input"
                                        value="Non Beras" role="button">
                                    <span class="form-check-label text-muted">Non Beras</span>
                                </label>
                            </div>
                            @error('staple_food')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="form-label pt-0 required">Mempunyai Jamban</label>
                            <div>
                                <label class="form-check form-check-inline" role="button">
                                    <input type="radio" name="have_toilet" wire:model.blur="haveToilet" class="form-check-input"
                                        value="1" role="button">
                                    <span class="form-check-label text-muted">Ya</span>
                                </label>
                                <label class="form-check form-check-inline" role="button">
                                    <input type="radio" name="have_toilet" wire:model.blur="haveToilet" class="form-check-input"
                                        value="0" role="button">
                                    <span class="form-check-label text-muted">Tidak</span>
                                </label>
                            </div>
                            @error('have_toilet')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="form-label pt-0 required">Mempunyai Tempat Pembuangan Sampah</label>
                            <div>
                                <label class="form-check form-check-inline" role="button">
                                    <input type="radio" name="have_landfill" wire:model.blur="haveLandfill" class="form-check-input"
                                        value="1" role="button">
                                    <span class="form-check-label text-muted">Ya</span>
                                </label>
                                <label class="form-check form-check-inline" role="button">
                                    <input type="radio" name="have_landfill" wire:model.blur="haveLandfill" class="form-check-input"
                                        value="0" role="button">
                                    <span class="form-check-label text-muted">Tidak</span>
                                </label>
                            </div>
                            @error('have_landfill')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="row mb-3">
                            <label class="form-label pt-0 required">Mempunyai Saluran Pembuangan Air Limbah</label>
                            <div>
                                <label class="form-check form-check-inline" role="button">
                                    <input type="radio" name="have_sewerage" wire:model.blur="haveSewerage" class="form-check-input"
                                        value="1" role="button">
                                    <span class="form-check-label text-muted">Ya</span>
                                </label>
                                <label class="form-check form-check-inline" role="button">
                                    <input type="radio" name="have_sewerage" wire:model.blur="haveSewerage" class="form-check-input"
                                        value="0" role="button">
                                    <span class="form-check-label text-muted">Tidak</span>
                                </label>
                            </div>
                            @error('have_sewerage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="form-label pt-0 required">Menempel Stiker P4K</label>
                            <div>
                                <label class="form-check form-check-inline" role="button">
                                    <input type="radio" name="pasting_p4k_sticker" wire:model.blur="pastingP4kSticker"
                                        class="form-check-input" value="1" role="button">
                                    <span class="form-check-label text-muted">Ya</span>
                                </label>
                                <label class="form-check form-check-inline" role="button">
                                    <input type="radio" name="pasting_p4k_sticker" wire:model.blur="pastingP4kSticker"
                                        class="form-check-input" value="0" role="button">
                                    <span class="form-check-label text-muted">Tidak</span>
                                </label>
                            </div>
                            @error('pasting_p4k_sticker')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label class="form-label pt-0 required">Kriteria Rumah</label>
                            <div>
                                <label class="form-check form-check-inline" role="button">
                                    <input type="radio" name="house_criteria" wire:model.blur="houseCriteria" class="form-check-input"
                                        value="Sehat" role="button">
                                    <span class="form-check-label text-muted">Sehat</span>
                                </label>
                                <label class="form-check form-check-inline" role="button">
                                    <input type="radio" name="house_criteria" wire:model.blur="houseCriteria" class="form-check-input"
                                        value="Kurang Sehat" role="button">
                                    <span class="form-check-label text-muted">Kurang Sehat</span>
                                </label>
                            </div>
                            @error('house_criteria')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-footer d-flex justify-content-between">
                    <button type="button" wire:click="back(1)" class="btn btn-secondary me-auto">
                        Sebelumnya
                    </button>
                    <button type="button" wire:click="secondStepSubmit" class="btn btn-primary">
                        Selanjutnya
                    </button>
                </div>
            </div>

            {{-- Step 3 --}}
            <div class="{{ $currentStep == 3 ? '' : 'd-none' }}">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th colspan="7" class="text-center">Jumlah</th>
                            </tr>
                            <tr>
                                <th>Balita</th>
                                <th>Pasangan Usia Subur</th>
                                <th>Wanita Usia Subur</th>
                                <th>Orang Buta</th>
                                <th>Ibu Hamil</th>
                                <th>Ibu Menyusui</th>
                                <th>Lansia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="number" wire:model.blur='toddlersNumber'
                                        class="form-control @error('toddlers_number') is-invalid @enderror" placeholder="0"
                                        style="width: 9rem">
                                    @error('toddlers_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model.blur='pusNumber'
                                        class="form-control @error('pus_number') is-invalid @enderror" placeholder="0" style="width: 9rem">
                                    @error('toddlers_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model.blur='wusNumber'
                                        class="form-control @error('wus_number') is-invalid @enderror" placeholder="0" style="width: 9rem">
                                    @error('wus_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model.blur='blindPeopleNumber'
                                        class="form-control @error('blind_people_number') is-invalid @enderror" placeholder="0"
                                        style="width: 9rem">
                                    @error('blind_people_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model.blur='pregnantWomenNumber'
                                        class="form-control @error('pregnant_women_number') is-invalid @enderror" placeholder="0"
                                        style="width: 9rem">
                                    @error('pregnant_women_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model.blur='breastfeedingMotherNumber'
                                        class="form-control @error('breastfeeding_mother_number') is-invalid @enderror" placeholder="0"
                                        style="width: 9rem">
                                    @error('breastfeeding_mother_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model.blur='elderlyNumber'
                                        class="form-control @error('elderly_number') is-invalid @enderror" placeholder="0"
                                        style="width: 9rem">
                                    @error('elderly_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="form-footer d-flex justify-content-between">
                    <button type="button" wire:click="back(2)" class="btn btn-secondary">Sebelumnya</button>
                    <button type="button" wire:click="thirdStepSubmit" class="btn btn-primary">Selanjutnya</button>
                </div>
            </div>

            {{-- Step 4 --}}
            <div class="{{ $currentStep == 4 ? '' : 'd-none' }}">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped table-hover">
                        <thead>
                            <tr>
                                <th rowspan="2">
                                    <button type="button" class="btn btn-outline-primary" wire:click='addFamilyMember'>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
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
                                        @if (!$loop->first)
                                            <button type="button" class="btn btn-outline-danger"
                                                wire:click='removeFamilyMember({{ $index }})'>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                                        <input type="text" wire:model.blur='familyMembers.{{ $index }}.nik_number'
                                            class="form-control @error('family_members.' . $index . '.nik_number') is-invalid @enderror"
                                            placeholder="No. NIK..." style="width: 10rem">
                                        @error('family_members.' . $index . '.nik_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" wire:model.blur='familyMembers.{{ $index }}.name'
                                            class="form-control @error('family_members.' . $index . '.name') is-invalid @enderror"
                                            placeholder="Nama Lengkap..." style="width: 12rem" @readonly($loop->first)>
                                        @error('family_members.' . $index . '.name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="date" wire:model.blur='familyMembers.{{ $index }}.birth_date'
                                            class="form-control @error('family_members.' . $index . '.birth_date') is-invalid @enderror"
                                            placeholder="Tgl. Lahir" style="width: 11rem">
                                        @error('family_members.' . $index . '.birth_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <select wire:model.blur='familyMembers.{{ $index }}.status'
                                            class="form-select @error('family_members.' . $index . '.status') is-invalid @enderror"
                                            style="width: 12rem" @disabled($loop->first)>
                                            <option value="">Status di Keluarga</option>
                                            <option value="Kepala Keluarga" @selected(!empty('family_members.0.name'))>Kepala Keluarga</option>
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
                                        <select wire:model.blur='familyMembers.{{ $index }}.marital_status'
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
                                        <select wire:model.blur='familyMembers.{{ $index }}.gender'
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
                                        <select wire:model.blur='familyMembers.{{ $index }}.last_education'
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
                                        <input type="text" wire:model.blur='familyMembers.{{ $index }}.profession'
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

                <div class="form-footer d-flex justify-content-between">
                    <button type="button" wire:click="back(3)" class="btn btn-secondary">Sebelumnya</button>
                    <button type="button" wire:click="forthStepSubmit" class="btn btn-primary">Selanjutnya</button>
                </div>
            </div>

            {{-- Step 5 --}}
            <div class="{{ $currentStep == 5 ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Usaha Peningkatan Pendapatan Keluarga</label>
                        <textarea wire:model.blur='up2kActivity' class="form-control @error('up2k_activity') is-invalid @enderror"
                            placeholder="Usaha Peningkatan Pendapatan Keluarga..." rows="4"></textarea>
                        @error('up2k_activity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Kegiatan Usaha Kesehatan Lingkungan</label>
                        <textarea wire:model.blur='envHealthActivity' class="form-control @error('env_health_activity') is-invalid @enderror"
                            placeholder="Kegiatan Usaha Kesehatan Lingkungan..." rows="4"></textarea>
                        @error('env_health_activity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-footer d-flex justify-content-between">
                    <button type="button" wire:click="back(4)" class="btn btn-secondary">Sebelumnya</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
