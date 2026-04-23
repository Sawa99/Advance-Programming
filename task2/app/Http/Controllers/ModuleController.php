<?php
namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Award;
use App\Models\Assignment;
use Illuminate\Http\Request;

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
            $module = Module::with('assignments.marks')->findOrFail($request->id);
            return view('modules.show', ['module' => $module]);
        }
        public function create(Request $request)
        {
            $awards = Award::all();
            return view('modules.create', ['awards' => $awards]);
        }

        public function store(Request $request)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'credits' => 'required|integer|min:0',
                'level' => 'required|integer|min:1',
                'awards' => 'nullable|array',
                'awards.*' => 'exists:awards,id',
            ]);

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

        public function update(Request $request)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'credits' => 'required|integer|min:0',
                'level' => 'required|integer|min:1',
                'awards' => 'nullable|array',
                'awards.*' => 'exists:awards,id',
            ]);

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
