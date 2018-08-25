<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\ChecklistItem;
use App\Http\Requests\AddChecklistItemRequest;

class ChecklistItemsController extends Controller
{
    public function store(AddChecklistItemRequest $request, Checklist $checklist)
    {
        $checklist->items()->create($request->only('name'));

        return redirect()->to(route('checklists.show', $checklist));
    }

    public function update(AddChecklistItemRequest $request, ChecklistItem $item)
    {
        $item->update($request->only('name'));
    }

    public function destroy(ChecklistItem $item)
    {
        $item->delete();
    }

    public function toggleComplete(ChecklistItem $item)
    {
        $item->isCompleted() ? $item->makeIncomplete() : $item->makeComplete();
    }
}
