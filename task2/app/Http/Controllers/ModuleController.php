<?php
namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Award;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Requests\ModuleRequest;
use App\Helpers\ClassificationHelper;

class ModuleController extends Controller
{
    //needs to display module name, credits, level, and assignments with their respective mark, put as ungraded if no mark
        public function index(Request $request)
        {
            $modules = Module::with('assignments.marks')->get();
            return view('modules.index', compact('modules'));
        }
        public function show(Request $request)
        {
            $module = Module::with(['assignments.marks' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
                ->findOrFail($request->id);

            $currentPercentage = ClassificationHelper::modulePercentage($module->assignments);
            $marksStillNeeded  = ClassificationHelper::marksStillNeeded($module->assignments);

            return view('modules.show', compact('module', 'currentPercentage', 'marksStillNeeded'));
        }
        public function create(Request $request)
        {
            $awards = Award::all();
            return view('modules.create', ['awards' => $awards]);
        }

    public function store(ModuleRequest $request)
        {
            $validated = $request->validated();
            $module = Module::create($validated);

            if ($request->has('awards')) {
                $module->awards()->sync($request->awards);
            }

            return redirect()->route('modules.index')->with('success', 'Module created successfully.');
        }

        public function edit(Request $request)
        {
            $module = Module::findOrFail($request->id);
            $awards = Award::all();
            return view('modules.edit', ['module' => $module, 'awards' => $awards]);
        }

    public function update(ModuleRequest $request, Module $module)
        {
            $validated = $request->validated();

            $module = Module::findOrFail($request->id);
            $module->update($validated);

            if ($request->has('awards')) {
                $module->awards()->sync($request->awards);
            } else {
                $module->awards()->detach();
            }

            return redirect()->route('modules.index')->with('success', 'Module updated successfully.');
        }

        public function destroy(Request $request)
        {
            $module = Module::findOrFail($request->id);
            $module->delete();

            return redirect()->route('modules.index')->with('success', 'Module deleted successfully.');
        }
}
