<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\FamilyBuilding;
use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\FamilyActivity;
use App\Models\FamilyMember;
use App\Models\FamilyNumber;

class MemberController extends Controller
{
    public function index()
    {
        return view('pages.backend.data-input.member-index', [
            'title' => 'Anggota Dasawisma'
        ]);
    }

    public function create()
    {
        return view('pages.backend.data-input.member-create', [
            'title' => 'Tambah Anggota Dasawisma'
        ]);
    }

    public function editFamily(string $kkNumber)
    {
        $data = Family::select([
            'id', 'kk_number', 'dasawisma_id', 'kk_number', 'kk_head', 'user_id'
        ])
            ->where('kk_number', '=', $kkNumber)
            ->first();

        return view('pages.backend.data-input.member-edit', [
            'title' => 'Edit Family',
            'data' => $data,
        ]);
    }

    public function editFamilyBuilding(string $kkNumber)
    {
        $family = Family::select([
            'id', 'kk_number', 'dasawisma_id', 'kk_number', 'kk_head', 'user_id'
        ])
            ->where('kk_number', '=', $kkNumber)
            ->first();

        $data = FamilyBuilding::select([
            'id', 'family_id', 'staple_food', 'have_toilet', 'water_src', 'have_landfill',
            'have_sewerage', 'pasting_p4k_sticker', 'house_criteria',
        ])
            ->with('family:id,dasawisma_id,kk_number,kk_head,user_id')
            ->whereBelongsTo($family)
            ->first();

        return view('pages.backend.data-input.member-edit', [
            'title' => 'Edit Family Building',
            'data' => $data,
        ]);
    }

    public function editFamilyNumber(string $kkNumber)
    {
        $family = Family::select(['id', 'kk_number'])
            ->where('kk_number', '=', $kkNumber)
            ->first();

        $data = FamilyNumber::select([
            'id', 'family_id', 'toddlers_number', 'pus_number', 'wus_number', 'blind_people_number',
            'pregnant_women_number', 'breastfeeding_mother_number', 'elderly_number',
        ])
            ->with('family:id,dasawisma_id,kk_number,kk_head,user_id')
            ->whereBelongsTo($family)
            ->first();

        return view('pages.backend.data-input.member-edit', [
            'title' => 'Edit Family Number',
            'data' => $data,
        ]);
    }

    public function editFamilyMember(string $kkNumber)
    {
        $family = Family::select(['id', 'kk_number'])
            ->where('kk_number', '=', $kkNumber)
            ->first();

        $data = FamilyMember::select([
            'id', 'family_id', 'nik_number', 'name', 'slug', 'birth_date', 'status',
            'marital_status', 'gender', 'last_education', 'profession',
        ])
            ->with('family:id,dasawisma_id,kk_number,kk_head,user_id')
            ->whereBelongsTo($family)
            ->get()->toArray();

        return view('pages.backend.data-input.member-edit', [
            'title' => 'Edit Family Member',
            'data' => $data,
        ]);
    }

    public function editFamilyActivity(string $kkNumber)
    {
        $family = Family::select(['id', 'kk_number'])
            ->where('kk_number', '=', $kkNumber)
            ->first();

        $data = FamilyActivity::select([
            'id', 'family_id', 'up2k_activity', 'env_health_activity'
        ])
            ->with('family:id,dasawisma_id,kk_number,kk_head,user_id')
            ->whereBelongsTo($family)
            ->first();

        return view('pages.backend.data-input.member-edit', [
            'title' => 'Edit Family Activity',
            'data' => $data,
        ]);
    }
}
