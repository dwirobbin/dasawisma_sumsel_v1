<div>
    <form class="card" wire:submit.prevent="update" method="post" autocomplete="off">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Edit Jumlah Anggota</h2>

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
                        <input type="text" wire:model='kkHead' class="form-control @error('kk_head') is-invalid @enderror"
                            placeholder="Nama Kepala Keluarga...">
                        @error('kk_head')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-3">
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
                                    <input type="number" wire:model='toddlersNumber'
                                        class="form-control @error('toddlers_number') is-invalid @enderror" placeholder="0" style="width: 9rem">
                                    @error('toddlers_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model='pusNumber' class="form-control @error('pus_number') is-invalid @enderror"
                                        placeholder="0" style="width: 9rem">
                                    @error('toddlers_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model='wusNumber' class="form-control @error('wus_number') is-invalid @enderror"
                                        placeholder="0" style="width: 9rem">
                                    @error('wus_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model='blindPeopleNumber'
                                        class="form-control @error('blind_people_number') is-invalid @enderror" placeholder="0"
                                        style="width: 9rem">
                                    @error('blind_people_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model='pregnantWomenNumber'
                                        class="form-control @error('pregnant_women_number') is-invalid @enderror" placeholder="0"
                                        style="width: 9rem">
                                    @error('pregnant_women_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model='breastfeedingMotherNumber'
                                        class="form-control @error('breastfeeding_mother_number') is-invalid @enderror" placeholder="0"
                                        style="width: 9rem">
                                    @error('breastfeeding_mother_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" wire:model='elderlyNumber'
                                        class="form-control @error('elderly_number') is-invalid @enderror" placeholder="0" style="width: 9rem">
                                    @error('elderly_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
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
