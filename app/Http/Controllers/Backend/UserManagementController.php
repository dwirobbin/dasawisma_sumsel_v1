<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        return view('pages.backend.management.user-index', [
            'title' => 'Users',
        ]);
    }

    public function create()
    {
        return view('pages.backend.management.user-create', [
            'title' => 'Tambah User',
        ]);
    }

    public function edit(User $user)
    {
        return view('pages.backend.management.user-edit', [
            'title' => 'Edit User',
            'user' => $user,
        ]);
    }
}
