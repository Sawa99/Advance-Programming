<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
use App\Models\Assignment;

class MarkController extends Controller
{
    public function create(Request $request)
    {
        return view('marks.create');
    }

    public function store(Request $request)
    {
        $assignment = Assignment::findOrFail($request->input('assignment_id'));

        $validated = $request->validate([
            'mark' => 'required|numeric|min:0|max:' . $assignment->total_marks,
            'assignment_id' => 'required|exists:assignments,id',
        ]);

        $mark = new Mark();
        $mark->mark = $validated['mark'];
        $mark->assignment_id = $validated['assignment_id'];
        $mark->save();

        return redirect()->route('assignments.index');
    }

    public function edit(Request $request)
    {
        $mark = Mark::findOrFail($request->id);
        return view('marks.edit', ['mark' => $mark]);
    }

    public function update(Request $request)
    {
        $assignment = Assignment::findOrFail($request->input('assignment_id'));

        $validated = $request->validate([
            'mark' => 'required|numeric|min:0|max:' . $assignment->total_marks,
            'assignment_id' => 'required|exists:assignments,id',
        ]);

        $mark = Mark::findOrFail($request->id);
        $mark->update($validated);

        return redirect()->route('assignments.index');
    }

    public function destroy(Request $request)
    {
        $mark = Mark::findOrFail($request->id);
        $mark->delete();

        return redirect()->route('assignments.index');
    }
}
