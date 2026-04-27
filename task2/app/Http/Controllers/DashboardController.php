<?php

namespace App\Http\Controllers;

use App\Models\Award;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $award = Award::with(['modules.assignments.marks' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->find($user->award_id);

        $modules = $award ? $award->modules : collect();

        return view('dashboard', ['modules' => $modules]);
    }
}
