<?php


namespace Tests\Acceptance;


use App\Article;
use App\Magazine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MagazineItemPageTest extends TestCase
{
    private $magazine;

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->magazine = factory(Magazine::class)->create();
        $this->url = 'magazines/'.$this->magazine->id;
        $this->refreshResponse();

    }

    /** @test */
    public function it_returns_200()
    {
        $this->response->assertStatus(200);
    }

    /** @test */
    public function it_has_correct_structure()
    {
        $this->response->assertSee("<h1>{$this->magazine->name}</h1>");
        $this->response->assertSee('<main-menu></main-menu>');
        $this->response->assertSee('<div class="breadcrumbs">');
        $this->response->assertDontSee('<div class="pagination">');
    }

    /** @test */
    public function it_has_search_block()
    {
        $this->response->assertSee('<section class="search-block">');
    }

    /** @test */
    public function it_has_magazine_data()
    {
        $this->response->assertSee('magazine-item__img');
        $this->response->assertSee($this->magazine->imgSrc());
        $this->response->assertSee('<a href="'.$this->magazine->link.'" class="external-link" target="_blank">'.$this->magazine->link.'</a>');
    }

    /** @test */
    public function it_has_more_magazine_block()
    {
        $moreCount = config('content.magazines-in-more-block') +1;
        $this->response->assertDontSee('magazine-item__more'); // only one magazine, nothing to show
        $moreMagazines = factory(Magazine::class,$moreCount)->create();
        $this->refreshResponse();
        $this->response->assertSee('magazine-item__more'); // now we have
        $item = $moreMagazines[0];
        $this->response->assertSee('<li><a href="'.$item->route().'" class="inner-link" data-count="');
        $this->response->assertSee('">'.$item->name.'</a></li>');
        $this->response->assertSee('data-count="'. ($moreCount - 1).'"');
        $this->response->assertDontSee('data-count="'.$moreCount.'"');

    }

    /** @test */
    public function it_has_linked_articles()
    {
        $this->response->assertDontSee('class="linked-articles"'); //block is hidden if we have no linked articles
        $articles = factory(Article::class,3)->create([
            'magazine_id' => $this->magazine->id
        ]);
        $this->refreshResponse();
        $this->response->assertSee('class="linked-articles"'); //block exists if we have linked articles
        foreach ($articles as $article){
            $this->response->assertSee('<li><a href="'.$article->route().'">'.$article->title.'</a></li>');
        }

    }

}
