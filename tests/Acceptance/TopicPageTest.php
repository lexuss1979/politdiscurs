<?php

namespace Tests\Acceptance;


use App\Article;
use App\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\DomCrawler\Crawler;

class TopicPageTest extends \Tests\TestCase
{
    use RefreshDatabase;

    private $rootTopic;
    private $targetTopic;
    private $childTopics;
    private $articles;
    private $pageCount;
    private $articlesCount;

    protected function setUp(): void
    {

        parent::setUp(); // TODO: Change the autogenerated stub
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
        factory(Article::class,$this->articlesCount)->create(['topic_id'=>$this->childTopics[0], 'format' => Article::PDF_TYPE]);
        $this->articles = Article::orderBy('title')->get();

        $this->url = 'topics/'.$this->targetTopic->id;
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

        $this->response->assertSee('<h1>'.$this->targetTopic->title.'</h1>');
        $this->response->assertSee('<div class="main-topic">'.$this->rootTopic->title.'</div>');
        $this->response->assertSee('<h2>'.config('content.default_H2').'</h2>');
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

        $this->response->assertSee('<a target="_blank" href="'.$this->articles[0]->route().'" class="item__header">'.$this->articles[0]->title.'</a>');
        $this->response->assertSee('<a target="_blank" href="'.$this->articles[0]->route().'"><img src="'.$this->articles[0]->imgSrc().'" alt="'.$this->articles[0]->title.'"><span class="letter');

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
        $this->response->assertSee('<a target="_blank" href="'.$this->articles[0]->route().'" class="item__header">'.$this->articles[0]->title.'</a>');
        $this->response->assertDontSee('<a target="_blank" href="'.$this->articles[config('content.articles-per-page')]->route().'" class="item__header">'.$this->articles[config('content.articles-per-page')]->title.'</a>');
        $responsePage2  = $this->get($this->url.'?page=2');
        $responsePage2->assertDontSee('<a target="_blank" href="'.$this->articles[0]->route().'" class="item__header">'.$this->articles[0]->title.'</a>');
        $responsePage2->assertSee('<a target="_blank" href="'.$this->articles[config('content.articles-per-page')]->route().'" class="item__header">'.$this->articles[config('content.articles-per-page')]->title.'</a>');
    }

    /** @test */
    public function it_contains_filter_data()
    {
        $this->response->assertSee('return {"authors":');
    }

    /** @test */
    public function items_has_all_attributes()
    {

        $article = $this->articles[0];
        $article->authors_string = 'Test Authors';
        $article->img = 'file_name_ABC.jpg';
        $article->format = Article::TEXT_TYPE;
        $article->annotation = 'Example annotation for article';
        $article->save();
        $this->refreshResponse();
        $crawler = new Crawler($this->response->content());

        $testingItem = $crawler->filter('.item[data-id="'.$article->id.'"]');
        $this->assertCount(1,$testingItem);

        $img = $testingItem->filter('.item__img  img');
        $this->assertCount(1,$img, 'Img was not found in item block');
        $this->assertStringContainsString($article->img, $img->attr('src'), 'Incorrect img src attribute');

        $headerLink = $testingItem->filter('.item__text > .item__header');
        $this->assertCount(1,$headerLink, '.item__header  element was not found in item block');
        $this->assertEquals($article->title, $headerLink->text(), 'Incorrect item header');

        $authors = $testingItem->filter('.item__text > .author');
        $this->assertCount(1,$authors, '.author  element was not found in item block');
        $this->assertStringContainsString($article->authors_string, $authors->text(),'Incorrect authors in item block' );

        $year = $testingItem->filter('.item__text > .year');
        $this->assertCount(1,$year, '.year  element was not found in item block');
        $this->assertStringContainsString($article->year, $year->text(), 'Incorrect year in item block');

        $annotation = $testingItem->filter('.item__text > .item__desc');
        $this->assertCount(1,$year,'.item__desc  element was not found in item block');
        $this->assertStringContainsString($article->annotation, $annotation->text(), 'Incorrect annotation in item block');


        $typeIcon = $testingItem->filter('.item__text > .item-type');
        $this->assertCount(1,$typeIcon,'Type-icon was not found in item block');

        $typeIcon = $testingItem->filter('.item__text > .item-type.type-text');
        $this->assertCount(1,$typeIcon,'incorrect Type-icon  in item block');


    }


//    /** @test */
//    public function items_has_correct_link()
//    {
//        $article = $this->articles[0];
//        $article->format = Article::TEXT_TYPE;
//        $article->save();
//        $this->refreshResponse();
//        $crawler = new Crawler($this->response->content());
//
//        $testingItem = $crawler->filter('.item[data-id="'.$article->id.'"]');
//        $this->assertCount(1,$testingItem);
//
//        $headerLink = $testingItem->filter('.item__text > .item__header');
//        $this->assertEquals($article->title, $headerLink->attr(['']), 'Incorrect item header');
//    }
}
