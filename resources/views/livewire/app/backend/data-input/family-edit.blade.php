<div>
    <form class="card" wire:submit.prevent="update" method="post" autocomplete="off">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Edit Kepala Keluarga</h2>

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
            <div class="form-footer d-flex justify-content-between">
                <a wire:navigate href="{{ route('admin.data_input.member.index') }}" class="btn btn-secondary me-auto">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>
