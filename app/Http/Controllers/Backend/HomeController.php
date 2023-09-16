<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Family;
use App\Models\Dasawisma;
use App\Models\FamilyMember;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $dataCount['users'] = User::selectRaw("
            COUNT(users.id) AS users_count
        ")->first();

        $dataCount['dasawismas'] = Dasawisma::selectRaw("
            COUNT(dasawismas.id) AS dasawismas_count
        ")->first();

        $dataCount['families'] = Family::selectRaw("
            COUNT(families.id) AS families_count
        ")->first();

        $dataCount['family_members'] = FamilyMember::selectRaw("
            COUNT(family_members.id) AS family_members_count
        ")->first();

        return view('pages.backend.home', [
            'title'     => 'Dashboard',
            'dataCount' => $dataCount,
        ]);
    }
}
