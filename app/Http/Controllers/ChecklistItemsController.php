<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\ChecklistItem;
use Illuminate\Http\Request;
use App\Http\Requests\AddChecklistItemRequest;

class ChecklistItemsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddChecklistItemRequest $request, Checklist $checklist)
    {
        $checklist->items()->create($request->only('name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddChecklistItemRequest $request, ChecklistItem $item)
    {
        $item->update($request->only('name'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChecklistItem $item)
    {
        $item->delete();
    }

    public function toggleComplete(ChecklistItem $item)
    {
        $item->isCompleted() ? $item->makeIncomplete() : $item->makeComplete();
    }
}
