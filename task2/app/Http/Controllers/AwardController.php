<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Book;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    public function index(Request $request)
    {
        $awards = Award::all();
        return view('awards.index',
            ['award' => $awards]
        );
    }

    public function show(Request $request){
        $award = Award::all()->findOrFail($request->id);
        return view('awards.show',
            ['award' => $award]
        );
    }

    public function create(Request $request)
    {
        return view('awards.create');
    }

    public function store(Request $request)
    {
        //not moving to a helper function as for awards it is only name.
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        $award = new Award();
        $award->name = $validated['name'];
        $award->save();
        return redirect()->route('awards.index');
    }

    public function edit(Request $request)
    {
        $award = Award::all()->findOrFail($request->id);
        return view('awards.edit',
            ['award' => $award]
        );
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        $award = Award::findOrFail($request->id);
        $award->name = $validated['name'];
        $award->save();

        return redirect()->route('award.show', [
            'id' => $award->id
        ]);
    }

    public function destroy(Request $request)
    {
        $award = Award::findOrFail($request->id);
        $award->delete();
        return redirect()->route('awards.index');
    }
}
