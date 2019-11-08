<?php

namespace Tests\Acceptance;

use App\Article;
use App\Magazine;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MagazinesPageTest extends \Tests\TestCase
{
    use RefreshDatabase;

    private $magazines;
    private $articles;


    protected function setUp(): void
    {
        parent::setUp();
        $magazinesCountFor3pages = 1 + (config('content.magazines-per-page')*2);
        $this->magazines = factory(Magazine::class, $magazinesCountFor3pages)->create();
        $this->articles = factory(Article::class,3)->create([
            'magazine_id' => $this->magazines[0]->id
        ]);
        $this->response = $this->get('magazines/');
    }

    /** @test */
    public function it_return_200()
    {
        $this->response->assertStatus(200);
    }

    /** @test */
    public function it_has_correct_structure()
    {
        $this->response->assertSee("<h1>Журналы</h1>");
        $this->response->assertSee('<main-menu></main-menu>');
        $this->response->assertSee('<div class="breadcrumbs">');
    }

    /** @test */
    public function it_has_items()
    {
        $item = $this->magazines[0];
        $this->response->assertSee('<a href="'.$item->route().'"><img src="'.$item->imgSrc().'" alt=""><span>'.$item->name.'</span></a>');
    }

    /** @test */
    public function it_has_paging()
    {
        $this->response->assertSee('<div class="pagination">');
        $this->response->assertSee('<div class="current"><input type="text" value="1"');
        $this->response->assertSee('<div class="comment">из 3</div>');
        $this->response->assertSee('href="'.route('magazines').'?page=2"');
    }

    /** @test */
    public function paging_working_correct()
    {

        $itemFromPage1 = $this->magazines[0];
        $itemFromPage2 = $this->magazines[config('content.magazines-per-page') + 1];
        $this->response->assertSee('<a href="'.$itemFromPage1->route().'">');
        $this->response->assertDontSee('<a href="'.$itemFromPage2->route().'">');
        $responsePage2 = $this->get(route('magazines').'?page=2');
        $responsePage2->assertDontSee('<a href="'.$itemFromPage1->route().'">');
        $responsePage2->assertSee('<a href="'.$itemFromPage2->route().'">');


    }

    /** @test */
    public function it_can_parse_DOM()
    {
        $crawler = new Crawler($this->response->content());
        $this->assertCount(2,$crawler->filter('h1'));
        $this->assertCount(config('content.magazines-per-page'),$crawler->filter('div.tile'));
    }




}
