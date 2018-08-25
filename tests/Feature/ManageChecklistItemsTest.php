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
        ])->assertRedirect(route('checklists.show', $checklist));

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

        $this->put(route('checklists.items.complete.toggle', $checklistItem))->assertStatus(200);

        $this->assertTrue($checklistItem->fresh()->isCompleted());
    }

    /** @test */
    public function completed_items_can_be_marked_as_incomplete()
    {
        $checklistItem = factory(ChecklistItem::class)->create([
            'completed_at' => now(),
        ]);

        $this->put(route('checklists.items.complete.toggle', $checklistItem))->assertStatus(200);

        $this->assertFalse($checklistItem->fresh()->isCompleted());
    }

    /** @test */
    public function items_can_be_deleted()
    {
        $checklistItem = factory(ChecklistItem::class)->create();

        $this->delete(route('checklists.items.destroy', $checklistItem))->assertStatus(200);

        $this->assertNull($checklistItem->fresh());
    }

    /** @test */
    public function items_can_be_updated()
    {
        $checklistItem = factory(ChecklistItem::class)->create(['name' => 'old']);

        $this->put(route('checklists.items.update', $checklistItem), [
            'name' => 'new',
        ])->assertStatus(200);

        $this->assertEquals('new', $checklistItem->fresh()->name);
    }

    /** @test */
    public function the_name_field_is_required_to_update_an_item()
    {
        $checklistItem = factory(ChecklistItem::class)->create(['name' => 'old']);

        $this->put(route('checklists.items.update', $checklistItem), [
            'name' => null,
        ])->assertSessionHasErrors('name');

        $this->assertEquals('old', $checklistItem->fresh()->name);
    }
}
