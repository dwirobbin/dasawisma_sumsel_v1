<?php

namespace App\Http\Controllers\Backend;

use App\Models\Dasawisma;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DasawismaController extends Controller
{
    public function index(): View
    {
        return view('pages.backend.data-input.dasawisma-index', [
            'title' => 'Dasawisma',
        ]);
    }

    public function create(): View
    {
        return view('pages.backend.data-input.dasawisma-create', [
            'title' => 'Tambah Dasawisma',
        ]);
    }

    public function edit(Dasawisma $dasawisma): View
    {
        return view('pages.backend.data-input.dasawisma-edit', [
            'title' => 'Edit Dasawisma',
            'dasawisma' => $dasawisma,
        ]);
    }
}
