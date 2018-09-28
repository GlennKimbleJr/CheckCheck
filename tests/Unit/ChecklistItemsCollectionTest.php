<?php

namespace Tests\Unit;

use App\Checklist;
use Tests\TestCase;
use App\ChecklistItem;
use App\Collections\ChecklistItemsCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChecklistItemsCollectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function completed_returns_the_items_in_a_collection_marked_as_complete()
    {
        $checklist = factory(Checklist::class)->create();

        $complete = factory(ChecklistItem::class)->create([
            'checklist_id' => $checklist->id,
            'completed_at' => now(),
        ])->fresh();

        $incomplete = factory(ChecklistItem::class)->create([
            'checklist_id' => $checklist->id,
            'completed_at' => null,
        ])->fresh();

        $this->assertInstanceOf(ChecklistItemsCollection::class, $checklist->items);
        $this->assertEquals(2, $checklist->items->count());
        $this->assertEquals(1, $checklist->items->completed()->count());
        $this->assertTrue($checklist->items->completed()->contains($complete));
        $this->assertFalse($checklist->items->completed()->contains($incomplete));
    }

    /** @test */
    public function is_complete_returns_true_if_completed_matches_the_overall_count()
    {
        $checklist = factory(Checklist::class)->create();

        factory(ChecklistItem::class, 2)->create([
            'checklist_id' => $checklist->id,
            'completed_at' => now(),
        ]);

        $this->assertTrue($checklist->isComplete());
    }

    /** @test */
    public function is_complete_returns_false_if_completed_does_not_match_the_overall_count()
    {
        $checklist = factory(Checklist::class)->create();

        factory(ChecklistItem::class)->create([
            'checklist_id' => $checklist->id,
            'completed_at' => now(),
        ]);

        factory(ChecklistItem::class)->create([
            'checklist_id' => $checklist->id,
            'completed_at' => null
        ]);

        $this->assertFalse($checklist->isComplete());
    }
}
