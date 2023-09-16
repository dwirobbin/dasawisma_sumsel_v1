<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataRecapFamilyMemberController extends Controller
{
    public function index(Request $request)
    {
        $param = match (true) {
            str_contains(url()->current(), '/area') => $request->code,
            str_contains(url()->current(), '/dasawisma') => $request->slug,
            default => null,
        };

        return view('pages.backend.data-recap.family-member-index', [
            'title' => 'Rekap Data Anggota Keluarga',
            'param' => $param
        ]);
    }
}
