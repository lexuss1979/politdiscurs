<?php

namespace Tests\Acceptance;

use App\Article;
use App\Http\Controllers\ServiceController;
use App\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Author;
use Tests\TestCase;

class ArticlePageTest extends TestCase
{
    use RefreshDatabase;

    private $article;
    private $topic;
    private $author;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $sc = new ServiceController();
        $sc->createTopics();
        $this->topic = Topic::where('code',2 )->get()->first();
        $this->author = factory(Author::class)->create();
        $this->article = factory(Article::class)->create([
            'title' => 'Super article title',
            'format' => Article::TEXT_TYPE,
            'topic_id' => $this->topic->id,
            'file_id' => null,
            'authors_string' => $this->author->fio
        ]);
        $this->article->authors()->attach($this->author);
        $this->response = $this->get($this->article->route());
    }

    /** @test */
    public function it_return_200()
    {
        $this->response->assertStatus(200);
    }

    /** @test */
    public function it_has_correct_header()
    {
        $this->response->assertSee('article-item topic topic-'.$this->topic->code);
        $this->response->assertSee('<h1>'.$this->topic->title .'</h1>');
        $this->response->assertSee('<div class="main-topic">'.$this->topic->parent()->title.'</div>');
        $this->response->assertSee('<h2>'.config('content.default_H2').'</h2>');

    }

    /** @test */
    public function it_has_correct_structure()
    {
        $this->response->assertSee('<main-menu></main-menu>');
        $this->response->assertSee('<div class="breadcrumbs">');
        $this->response->assertDontSee('<div class="pagination">');

    }
    /** @test */
    public function it_show_title()
    {
        $this->response->assertSee("<h1>{$this->article->title}</h1>");
    }

    /** @test */
    public function it_show_content()
    {
        $this->response->assertSee($this->article->html);
    }

    /** @test */
    public function it_show_authors()
    {
        $this->response->assertSee('<div class="authors">'.$this->article->authors_string.'</div>');
    }

    /** @test */
    public function it_show_img()
    {
        $this->response->assertSee('<section class="article-item__img"><img src="'.$this->article->imgSrc().'"></section>');
    }

    /** @test */
    public function it_show_publishing_year()
    {
        $this->response->assertSee('<div class="year">'.$this->article->year.'</div>');
    }

    /** @test */
    public function it_has_more_articles_block()
    {
        $this->response->assertDontSee('<section class="article-item__more">'); //is hidden bc only one article exists

        factory(Article::class)->create(['topic_id'=>$this->article->topic_id]);
        $this->response = $this->get($this->article->route());
        $this->response->assertSee('<section class="article-item__more">'); //visible
    }


}

