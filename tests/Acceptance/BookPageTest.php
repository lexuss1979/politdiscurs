<?php

namespace Tests\Acceptance;


use App\Article;
use App\ContentType;
use App\Http\Controllers\ServiceController;
use App\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookPageTest extends \Tests\TestCase
{
    private $rootTopic;
    private $targetTopic;
    private $childTopics;
    private $books;
    private $pageCount;
    private $articlesCount;

    use RefreshDatabase;

    protected function setUp(): void
    {

        parent::setUp(); // TODO: Change the autogenerated stub

        $sc = new ServiceController();
        $sc->createContentTypes();

        $this->rootTopic = factory(Topic::class)->create([
            'title' => 'Root topic',
            'code' => Topic::OUTER_CODE
        ]);

        $this->targetTopic = factory(Topic::class)->create([
            'title' => 'Target topic',
            'code' => '12',
            'img' => 'test/path/to/topic-banner.jpg',
            'bgcolor'=> '#123456',
            'parent_topic_id' => $this->rootTopic->id
        ]);

        $this->childTopics = factory(Topic::class, 2)->create([
            'parent_topic_id' => $this->targetTopic->id
        ]);

        $this->pageCount = 3;
        $this->articlesCount = (config('content.articles-per-page')* ($this->pageCount-1)) + 1;

        factory(Article::class,$this->articlesCount)->create([
            'topic_id'=>$this->childTopics[0],
            'format' => Article::PDF_TYPE,
            'content_type_id' => ContentType::bookTypeID()
        ]);
        $this->books = Article::orderBy('title')->get();

        $this->url = 'books/'.$this->targetTopic->id;
        $this->response = $this->get($this->url);
        $this->withoutExceptionHandling();
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
        $this->response->assertSee('<div class="pagination">');
        $this->response->assertSee('<div class="current">');

    }

    /** @test */
    public function it_display_items()
    {
        if(config('content.show-letter-placeholder')){
            $this->response->assertSee('<div class="items-list letters">');
        } else {
            $this->response->assertSee('<div class="items-list">');
        }

        $this->response->assertSee('href="'.$this->books[0]->route().'" class="item__header">'.$this->books[0]->title.'</a>');
        $this->response->assertSee('href="'.$this->books[0]->route().'"><img src="'.$this->books[0]->imgSrc().'" alt="'.$this->books[0]->title.'"><span class="letter');

    }

    /** @test */
    public function it_display_paging()
    {

        $this->response->assertSee('<div class="current">1</div>');
        $this->response->assertSee('<div class="comment">из '.$this->pageCount.'</div>');
        $this->response->assertSee('<div class="btn-prev disabled"></div>');
        $this->response->assertSee('<a href="'.$this->url.'?page=2"><div class="btn-next"></div></a>');
    }

    /** @test */
    public function it_ca_show_concrete_page()
    {
        $this->response->assertSee($this->books[0]->title);
        $this->response->assertDontSee($this->books[config('content.articles-per-page')]->title);
        $responsePage2  = $this->get($this->url.'?page=2');
        $responsePage2->assertDontSee($this->books[0]->title);
        $responsePage2->assertSee($this->books[config('content.articles-per-page')]->title);
    }

    /** @test */
    public function it_contains_filter_data()
    {
        $this->response->assertSee('<book-filter inline-template :data=\'function(){return [');
    }
}
