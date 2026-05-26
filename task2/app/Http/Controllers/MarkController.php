<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mark;
use App\Rules\ValidMark;
use App\Models\Assignment;

class MarkController extends Controller
{
    public function create(Assignment $assignment)
    {
        return view('marks.create', compact('assignment'));
    }
    public function store(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'mark' => ['required', 'numeric', new ValidMark($assignment)],
        ]);

        $mark = new Mark();
        $mark->mark = $validated['mark'];
        $mark->assignment_id = $assignment->id;
        $mark->user_id = auth()->id();
        $mark->save();
        $assignment->module->updateStatus();


        return redirect()->route('assignments.show',  $assignment);
    }

    public function edit(Mark $mark)
    {
        $mark->load('assignment');
        return view('marks.edit', ['mark' => $mark]);
    }

    public function update(Request $request, Mark $mark)
    {
        $assignment = Assignment::findOrFail($request->input('assignment_id'));

        $validated = $request->validate([
            'mark' => ['required', 'numeric', new ValidMark($assignment)],
            'assignment_id' => 'required|exists:assignments,id',
        ]);

        $mark->update($validated);
        $assignment->module->updateStatus();

        return redirect()->route('assignments.show', $mark->assignment_id);
    }

    public function destroy(Request $request)
    {
        $mark = Mark::findOrFail($request->id);
        $mark->delete();

        return redirect()->route('assignments.index');
    }
}
