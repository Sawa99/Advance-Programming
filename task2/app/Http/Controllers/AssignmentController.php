<?php

namespace App\Http\Controllers;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller{
    public function index(Request $request){
        $assignments = Assignment::all();
        return view('assignments.index', compact('assignments'));
    }

    public function show(Request $request){
        $assignment = Assignment::with('module')->findOrFail($request->id);
        return view('assignments.show', ['assignment' => $assignment]);
    }

    public function create(Request $request){
        return view('assignments.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
        ]);
        $assignment = new Assignment();
        $assignment->name = $validated['name'];
        $assignment->module_id = $validated['module_id'];
        $assignment->save();
        return redirect()->route('assignments.index');
    }

    public function edit(Request $request){
        $assignment = Assignment::findOrFail($request->id);
        return view('assignments.edit', ['assignment' => $assignment]);
    }

    public function update(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
        ]);
        $assignment = Assignment::findOrFail($request->id);
        $assignment->update($validated);
        return redirect()->route('assignments.index');
    }

    public function destroy(Request $request){
        $assignment = Assignment::findOrFail($request->id);
        $assignment->delete();
        return redirect()->route('assignments.index');
    }
}
