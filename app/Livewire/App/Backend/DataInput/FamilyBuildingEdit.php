<?php

namespace App\Livewire\App\Backend\DataInput;

use Livewire\Component;
use App\Models\Dasawisma;
use App\Models\FamilyMember;
use App\Models\FamilyBuilding;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FamilyBuildingEdit extends Component
{
    public ?FamilyBuilding $familyBuilding = NULL;
    public ?FamilyMember $familyMember = NULL;

    public $dasawismas = [];
    public ?string $dasawismaId = NULL, $kkNumber = NULL, $kkHead = NULL;
    public $waterSrc = [];
    public ?string $stapleFood = NULL, $haveToilet = NULL, $haveLandfill = NULL, $haveSewerage = NULL, $pastingP4kSticker = NULL, $houseCriteria = NULL;

    public function mount($data)
    {
        $this->familyBuilding = $data;
        $this->familyMember = FamilyMember::select(['id', 'name', 'slug'])
            ->where([['family_id', '=', $data->family->id], ['name', '=', $data->family->kk_head]])
            ->first();

        $this->dasawismas = Dasawisma::get(['id', 'name']);

        $this->dasawismaId = $data->family->dasawisma_id;
        $this->kkNumber = $data->family->kk_number;
        $this->kkHead = $data->family->kk_head;
        $this->waterSrc = explode(',', $data->water_src);
        $this->stapleFood = $data->staple_food;
        $this->haveToilet = $data->have_toilet;
        $this->haveLandfill = $data->have_landfill;
        $this->haveSewerage = $data->have_sewerage;
        $this->pastingP4kSticker = $data->pasting_p4k_sticker;
        $this->houseCriteria = $data->house_criteria;
    }

    public function render()
    {
        return view('livewire.app.backend.data-input.family-building-edit');
    }

    public function update()
    {
        $validateData = Validator::make([
            'dasawisma_id'          => $this->dasawismaId,
            'kk_number'             => $this->kkNumber,
            'kk_head'               => $this->kkHead,
            'staple_food'           => $this->stapleFood,
            'water_src'             => $this->waterSrc,
            'have_toilet'           => $this->haveToilet,
            'have_landfill'         => $this->haveLandfill,
            'have_sewerage'         => $this->haveSewerage,
            'pasting_p4k_sticker'   => $this->pastingP4kSticker,
            'house_criteria'        => $this->houseCriteria,
        ], [
            'dasawisma_id'          => ['required', 'string'],
            'kk_number'             => ['required', 'numeric'],
            'kk_head'               => ['required', 'string'],
            'staple_food'           => ['required'],
            'water_src'             => ['required'],
            'have_toilet'           => ['required'],
            'have_landfill'         => ['required'],
            'have_sewerage'         => ['required'],
            'pasting_p4k_sticker'   => ['required'],
            'house_criteria'        => ['required'],
        ], [
            'required'              => ':attribute wajib diisi.',
            'string'                => ':attribute harus berupa string.',
            'numeric'               => ':attribute harus berupa angka.',
        ], [
            'dasawisma_id'          => 'Dasawisma',
            'kk_number'             => 'No. KK',
            'kk_head'               => 'Nama Kepala Keluarga',
            'staple_food'           => 'Makanan Pokok',
            'have_toilet'           => 'Mempunyai Toilet',
            'water_src'             => 'Sumber Air Keluarga',
            'have_landfill'         => 'Mempunyai TPS',
            'have_sewerage'         => 'Mempunyai SPAL',
            'pasting_p4k_sticker'   => 'Menempel Stiker P4K',
            'house_criteria'        => 'Kriteria Rumah',
        ])->validate();

        try {
            DB::beginTransaction();

            $this->familyBuilding->update([
                'staple_food'           => $validateData['staple_food'],
                'have_toilet'           => $validateData['have_toilet'],
                'water_src'             => implode(',', (array) $validateData['water_src']),
                'have_landfill'         => $validateData['have_landfill'],
                'have_sewerage'         => $validateData['have_sewerage'],
                'pasting_p4k_sticker'   => $validateData['pasting_p4k_sticker'],
                'house_criteria'        => $validateData['house_criteria'],
            ]);

            $this->familyMember->update([
                'name'  => str($validateData['kk_head'])->title(),
                'slug'  => str($validateData['kk_head'])->slug(),
            ]);

            $this->familyBuilding->family->update([
                'dasawisma_id' => $validateData['dasawisma_id'],
                'kk_number'    => $validateData['kk_number'],
                'kk_head'      => $validateData['kk_head'],
            ]);

            DB::commit();

            session()->flash('message', [
                'text' => "Data Bangunan milik {$this->familyBuilding->family->kk_head} berhasil diperbarui!",
                'type' => 'success',
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();

            session()->flash('message', [
                'text' => 'Terjadi suatu kesalahan!!',
                'type' => 'danger'
            ]);
        }

        return $this->redirect(route('admin.data_input.member.index', true));
    }
}
