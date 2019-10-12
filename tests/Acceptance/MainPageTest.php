<?php

namespace Tests\Acceptance;

use Illuminate\Foundation\Testing\RefreshDatabase;

class MainPageTest extends \Tests\TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_show_main_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_has_correct_layout()
    {
        $response = $this->get('/');
        $response->assertSee('<header');
        $response->assertSee('<main');
        $response->assertSee('<footer');
    }

}
