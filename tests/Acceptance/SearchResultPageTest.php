<?php

namespace Tests\Acceptance;

use App\Article;
use App\Magazine;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchResultPageTest extends \Tests\TestCase
{
    use RefreshDatabase;

    protected $query;
    private $articles;


    protected function setUp(): void
    {
        parent::setUp();

        $this->query = 'ABSOLUTELYUNIQUE WORDSEQUENCE';
        $this->url = route('search-results',['q' => $this->query]);
        $this->response = $this->get($this->url);
    }

    /** @test */
    public function it_return_200()
    {
        $this->response->assertStatus(200);
    }

    /** @test */
    public function it_has_correct_structure()
    {
        $this->response->assertSee('<main-menu></main-menu>');
        $this->response->assertSee('<div class="breadcrumbs">');
        $this->response->assertDontSee('<div class="pagination">'); //empty results
        $this->response->assertSee('<section class="search-panel">');
        $this->response->assertSee('<p class="nothing-found">');
        $this->response->assertSee('value="'.$this->query.'"');

    }

    /** @test */
    public function it_can_search_in_titles()
    {
        $wanted = factory(Article::class)->create(['title' => 'My UNIQ_MARK with '.$this->query.' in title.']);
        $unwanted = factory(Article::class)->create(['title' => 'My UNIQ_MARK.']);
        $response = $this->get(route('search-results',['q' => $this->query]));
        $response->assertDontSee('<p class="nothing-found">');
        $response->assertSee('<div class="item" data-id="'.$wanted->id.'">');
        $response->assertDontSee('<div class="item" data-id="'.$unwanted->id.'">');
        $response = $this->get(route('search-results',['q' => 'UNIQ_MARK']));

        $response->assertSee('<div class="item" data-id="'.$wanted->id.'">');
        $response->assertSee('<div class="item" data-id="'.$unwanted->id.'">');


    }

    /** @test */
    public function it_can_search_in_annotation()
    {
        $wanted = factory(Article::class)->create(['annotation' => 'My UNIQ_MARK with '.$this->query.' in title.']);
        $unwanted = factory(Article::class)->create(['annotation' => 'My UNIQ_MARK.']);
        $response = $this->get(route('search-results',['q' => $this->query]));
        $response->assertSee('<div class="item" data-id="'.$wanted->id.'">');
        $response->assertDontSee('<div class="item" data-id="'.$unwanted->id.'">');
        $response = $this->get(route('search-results',['q' => 'UNIQ_MARK']));

        $response->assertSee('<div class="item" data-id="'.$wanted->id.'">');
        $response->assertSee('<div class="item" data-id="'.$unwanted->id.'">');


    }


}
