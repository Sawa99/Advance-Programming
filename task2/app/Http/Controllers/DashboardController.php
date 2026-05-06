<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ClassificationHelper;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $user->load(['award.modules.assignments.marks' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }]);

        $modules = $user->award ? $user->award->modules : collect();

        // Build level 5 and level 6 module lists for prediction
        $level5Modules = [];
        $level6Modules = [];

        foreach ($modules as $module) {
            $actual = ClassificationHelper::modulePercentage($module->assignments);

            if ($actual !== null && $module->is_completed) {
                $percentage = $actual;
            } else {
                $predicted = $request->input('predictions.' . $module->id);
                if ($predicted === null || $predicted === '') {
                    continue;
                }
                $percentage = (float) $predicted;
            }

            $entry = ['percentage' => $percentage, 'credits' => $module->credits];

            if ($module->level === 5) {
                $level5Modules[] = $entry;
            } elseif ($module->level === 6) {
                $level6Modules[] = $entry;
            }
        }

        $prediction = ClassificationHelper::predictClassification($level5Modules, $level6Modules);

        return view('dashboard', ['modules' => $modules, 'user' => $user, 'prediction' => $prediction]);
    }
}
