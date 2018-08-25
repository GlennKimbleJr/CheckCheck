<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\Http\Requests\CreateChecklistRequest;

class ChecklistController extends Controller
{
    public function index()
    {
        return view('checklists.index', [
            'checklists' => Checklist::get(),
        ]);
    }

    public function create(Checklist $checklist)
    {
        return view('checklists.create', [
            'checklist' => $checklist,
        ]);
    }

    public function store(CreateChecklistRequest $request)
    {
        $checklist = Checklist::create($request->only('name'));

        return redirect()->to(route('checklists.show', $checklist));
    }

    public function show(Checklist $checklist)
    {
        $checklist->loadMissing('items');

        return view('checklists.show', compact('checklist'));
    }

    public function update(CreateChecklistRequest $request, Checklist $checklist)
    {
        $checklist->update($request->only('name'));
    }

    public function destroy(Checklist $checklist)
    {
        $checklist->delete();

        return redirect()->to(route('checklists.index'));
    }
}
