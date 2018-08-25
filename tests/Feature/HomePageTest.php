<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function when_you_visit_the_homepage_youll_be_redirected_to_the_checklists_index()
    {
        $this->get(route('home'))->assertRedirect(route('checklists.index'));
    }
}
