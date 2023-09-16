<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataRecapFamilyNumberController extends Controller
{
    public function index(Request $request)
    {
        $param = match (true) {
            str_contains(url()->current(), '/area') => $request->code,
            str_contains(url()->current(), '/dasawisma') => $request->slug,
            default => null,
        };

        return view('pages.backend.data-recap.family-number-index', [
            'title' => 'Rekap Data Jumlah Anggota',
            'param' => $param
        ]);
    }
}
