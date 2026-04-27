<?php

namespace App\Http\Controllers;
use App\Models\Assignment;
use App\Models\Module;
use Illuminate\Http\Request;

class AssignmentController extends Controller{
    public function index(Request $request){
        $assignments = Assignment::all();
        return view('assignments.index', compact('assignments'));
    }

    public function show(Request $request){
        $assignment = Assignment::with(['module', 'marks'])->findOrFail($request->id);
        $mark = $assignment->marks->firstWhere('user_id', auth()->id());
        return view('assignments.show', ['assignment' => $assignment, 'mark' => $mark]);
    }

    public function create(Request $request){
        $modules = Module::all();
        return view('assignments.create', ['modules' => $modules]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'weight' => 'required|numeric|min:0|max:100',
            'total_marks' => 'required|numeric|min:1',
        ]);
        $assignment = new Assignment();
        $assignment->name = $validated['name'];
        $assignment->module_id = $validated['module_id'];
        $assignment->weight = $validated['weight'];
        $assignment->total_marks = $validated['total_marks'];
        $assignment->save();
        return redirect()->route('modules.show', $assignment->module_id);
    }

    public function edit(Request $request){
        $assignment = Assignment::findOrFail($request->id);
        $modules = Module::all();
        return view('assignments.edit', ['assignment' => $assignment, 'modules' => $modules]);
    }

    public function update(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'weight' => 'required|numeric|min:0|max:100',
            'total_marks' => 'required|numeric|min:1',
        ]);
        $assignment = Assignment::findOrFail($request->id);
        $assignment->update($validated);
        return redirect()->route('assignments.show', $assignment->id);
    }

    public function destroy(Request $request){
        $assignment = Assignment::findOrFail($request->id);
        $assignment->delete();
        return redirect()->route('assignments.index');
    }
}
