<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\ChecklistItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChecklistItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_complete_method_sets_the_completed_at_timestamp()
    {
        $item = factory(ChecklistItem::class)->make();

        $this->assertNull($item->completed_at);

        $item->complete();

        $this->assertNotNull($item->completed_at);
    }

    /** @test */
    public function isCompleted_returns_true_if_the_completed_at_timestamp_is_not_null()
    {
        $item = factory(ChecklistItem::class)->make(['completed_at' => now()]);

        $this->assertTrue($item->isCompleted());
    }

    /** @test */
    public function isCompleted_returns_false_if_the_completed_at_timestamp_is_null()
    {
        $item = factory(ChecklistItem::class)->make(['completed_at' => null]);

        $this->assertFalse($item->isCompleted());
    }
}
