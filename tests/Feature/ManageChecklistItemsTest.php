<?php

namespace Tests\Feature;

use App\Checklist;
use Tests\TestCase;
use App\ChecklistItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageChecklistItemsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_item_can_be_added_to_a_checklist()
    {
        $checklist = factory(Checklist::class)->create();

        $this->post(route('checklists.items.store', $checklist), [
            'name' => 'Item 1',
        ])->assertStatus(200);

        $this->assertCount(1, $checklist->items);
        $this->assertEquals('Item 1', $checklist->items->first()->name);
    }

    /** @test */
    public function a_name_is_required_to_add_items_to_a_checklist()
    {
        $checklist = factory(Checklist::class)->create();

        $this->post(route('checklists.items.store', $checklist), [
            'name' => null,
        ])->assertSessionHasErrors('name');

        $this->assertEmpty($checklist->items);
    }

    /** @test */
    public function items_can_be_marked_as_complete()
    {
        $checklistItem = factory(ChecklistItem::class)->create();

        $this->put(route('checklist.items.complete', $checklistItem))->assertStatus(200);

        $this->assertTrue($checklistItem->fresh()->isCompleted());
    }

    /** @test */
    public function items_can_be_deleted()
    {
        $checklistItem = factory(ChecklistItem::class)->create();

        $this->delete(route('checklist.items.destroy', $checklistItem))->assertStatus(200);

        $this->assertNull($checklistItem->fresh());
    }
}
