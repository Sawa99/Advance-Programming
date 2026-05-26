<?php

namespace App\Http\Controllers;
use App\Models\Assignment;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Requests\AssignmentRequest;

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

    public function create(Module $module){
        return view('assignments.create', compact('module'));
    }

    public function store(AssignmentRequest $request, Module $module) {
        $validated = $request->validated();
        $assignment = new Assignment();
        $assignment->name = $validated['name'];
        $assignment->module_id = $module->id;
        $assignment->weight = $validated['weight'];
        $assignment->total_marks = $validated['total_marks'];
        $assignment->save();
        $module->updateStatus();
        return redirect()->route('modules.show', $assignment->module_id);
    }

    public function edit(Assignment $assignment) {
        $assignment->load('module');
        return view('assignments.edit', ['assignment' => $assignment]);
    }

    public function update(AssignmentRequest $request, Assignment $assignment){
        $validated = $request->validated();
        $assignment->update($validated);
        return redirect()->route('assignments.show', $assignment);
    }
    public function destroy(Assignment $assignment){
        $assignment = Assignment::findOrFail($assignment->id);
        $assignment->delete();
        return redirect()->route('assignments.index');
    }
}
