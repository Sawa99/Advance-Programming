<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
class MarkController extends Controller{

    public function index(Request $request){
        $marks = Mark::all();
        return view('marks.index', compact('marks'));
    }
    public function show(Request $request){
        $mark = Mark::with('assignment')->findOrFail($request->id);
        return view('marks.show', ['mark' => $mark]);
    }
    public function create(Request $request){
        return view('marks.create');
    }
    public function store(Request $request){
        $validated = $request->validate([
            'mark' => 'required|integer|min:0|max:100',
            'assignment_id' => 'required|exists:assignments,id',
        ]);
        $mark = new Mark();
        $mark->mark = $validated['mark'];
        $mark->assignment_id = $validated['assignment_id'];
        $mark->save();
        return redirect()->route('marks.index');
    }

    public function edit(Request $request){
        $mark = Mark::findOrFail($request->id);
        return view('marks.edit', ['mark' => $mark]);
    }
    public function update(Request $request){
        $validated = $request->validate([
            'mark' => 'required|integer|min:0|max:100',
            'assignment_id' => 'required|exists:assignments,id',
        ]);
        $mark = Mark::findOrFail($request->id);
    }
    public function destroy(Request $request){
        $mark = Mark::findOrFail($request->id);
        $mark->delete();
        return redirect()->route('marks.index');
    }
}
