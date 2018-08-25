<?php

namespace Tests\Feature;

use App\Checklist;
use Tests\TestCase;
use App\ChecklistItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageCheckListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_checklist_index_loads()
    {
        $checklist = factory(Checklist::class)->create();

        $this->get(route('checklists.index'))->assertStatus(200)->assertSee($checklist->name);
    }

    /** @test */
    public function the_create_checklist_page_loads()
    {
        $this->get(route('checklists.create'))->assertStatus(200);
    }

    /** @test */
    public function checklists_can_be_created()
    {
        $response = $this->post(route('checklists.store'), [
            'name' => 'Test Checklist',
        ]);

        $checklist = Checklist::first();
        $this->assertNotNull($checklist);
        $this->assertEquals('Test Checklist', $checklist->name);

        $response->assertRedirect(route('checklists.show', $checklist));
    }

    /** @test */
    public function the_name_field_is_required_to_create_a_checklist()
    {
        $response = $this->post(route('checklists.store'), [
            'name' => null,
        ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_checklist_can_be_updated()
    {
        $checklist = factory(Checklist::class)->create([
            'name' => 'Old name',
        ]);

        $this->put(route('checklists.update', $checklist), [
            'name' => 'New name',
        ])->assertStatus(200);

        $this->assertEquals('New name', $checklist->fresh()->name);
    }

    /** @test */
    public function the_name_field_is_required_to_update_a_checklist()
    {
        $checklist = factory(Checklist::class)->create([
            'name' => 'Old name',
        ]);

        $this->put(route('checklists.update', $checklist), [
            'name' => null,
        ])->assertSessionHasErrors('name');

        $this->assertEquals('Old name', $checklist->fresh()->name);
    }

    /** @test */
    public function the_show_checklist_page_loads()
    {
        $checklist = factory(Checklist::class)->create();

        $this->get(route('checklists.show', $checklist))
            ->assertStatus(200)
            ->assertSee($checklist->name);
    }

    /** @test */
    public function checklist_items_display_on_the_checklist_page()
    {
        $item = factory(ChecklistItem::class)->create();

        $this->get(route('checklists.show', $item->checklist))
            ->assertStatus(200)
            ->assertSee($item->name);
    }

    /** @test */
    public function items_belonging_to_another_checklist_wont_load_on_the_checklist_page()
    {
        $checklist = factory(Checklist::class)->create();

        $notYourItem = factory(ChecklistItem::class)->create();

        $this->get(route('checklists.show', $checklist))
            ->assertStatus(200)
            ->assertDontSee($notYourItem->name);
    }

    /** @test */
    public function a_checklist_can_be_deleted()
    {
        $checklist = factory(Checklist::class)->create();

        $this->delete(route('checklists.destroy', $checklist))
            ->assertRedirect(route('checklists.index'));

        $this->assertNull($checklist->fresh());
    }
}
