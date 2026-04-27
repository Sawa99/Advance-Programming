<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $user->load(['award.modules.assignments.marks' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }]);

        $modules = $user->award ? $user->award->modules : collect();

        return view('dashboard', ['modules' => $modules, 'user' => $user]);
    }
}
