<?php

namespace Tests\Acceptance;

use App\Http\Controllers\ServiceController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MainPageTest extends \Tests\TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $sc = new ServiceController();
        $sc->createTopics();
        $this->response = $this->get('/');
    }

    /** @test */
    public function it_can_show_main_page()
    {
        $this->response->assertStatus(200);
    }

    /** @test */
    public function it_has_correct_layout()
    {
        $this->response->assertSee('<header');
        $this->response->assertSee('<main');
        $this->response->assertSee('<footer');
    }

    /** @test */
    public function it_has_tile_menu()
    {
        $this->response->assertSee('<section class="topics">');
        for($i=1; $i<=12; $i++){
            $this->response->assertSee('<div class="tile topic-'.$i.'">');
        }
    }

    /** @test */
    public function it_has_page_class()
    {
        $this->response->assertSee('<main class="main-page">');
    }

}
