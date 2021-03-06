<?php

namespace Tests\Unit;

use App\Article;
use App\Author;
use App\ContentType;
use App\File;
use App\Http\Controllers\ServiceController;
use App\Magazine;
use App\Organisation;
use App\Region;
use App\Source;
use App\Topic;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    protected $article = null;
    protected function setUp(): void
    {
       parent::setUp(); // TODO: Change the autogenerated stub
        if( is_null($this->article)) {
            $this->article = factory(Article::class)->create(
                ['title'=>'This is a test article']
            );
            $this->article->authors()->attach(factory(Author::class)->create());
            $this->article->regions()->attach(factory(Region::class)->create());
            $this->article->organisations()->attach(factory(Organisation::class)->create());

        }
    }

    /** @test */
    public function it_can_create_an_article()
    {
        $this->assertDatabaseMissing('articles',['title'=>'test']);
        $article = factory(Article::class)->create(
            ['title'=>'test']
        );

        $this->assertDatabaseHas('articles',['title'=>'test']);


    }

    /** @test */
    public function article_has_author()
    {
        $this->assertInstanceOf(Collection::class, $this->article->authors);
        $this->assertGreaterThan(0,$this->article->authors[0]->id);
    }

    /** @test */
    public function it_has_parent_topic()
    {
        $this->assertInstanceOf(Topic::class, $this->article->topic);
        $this->assertGreaterThan(0,$this->article->topic->id);
    }

    /** @test */
    public function it_has_content_type()
    {
        $this->assertInstanceOf(ContentType::class, $this->article->contentType);
        $this->assertGreaterThan(0,$this->article->contentType->id);
    }

    /** @test */
    public function it_has_region()
    {
        $this->assertInstanceOf(Region::class, $this->article->regions()->first());
        $this->assertGreaterThan(0,$this->article->regions()->first()->id);
    }

    /** @test */
    public function it_has_source()
    {
        $this->assertInstanceOf(Source::class, $this->article->source);
        $this->assertGreaterThan(0,$this->article->source->id);
    }

    /** @test */
    public function it_has_file(){
        $this->assertInstanceOf(File::class, $this->article->file);
        $this->assertGreaterThan(0,$this->article->file->id);
    }

    /** @test */
    public function it_can_hasnt_file()
    {
        $article = $this->article = factory(Article::class)->create(
            [
                'title'=>'This is a test article',
                'file_id' => null
                ]
        );
        $this->assertNull($this->article->file);
    }


    /** @test */
    public function it_can_return_filtered_list()
    {
        $filtered = Article::getFilteredList();
        $this->assertCount(1,$filtered);

        $articles = factory(Article::class, 10)->create();
        $filtered = Article::getFilteredList();
        $this->assertCount(11,$filtered);
    }

    /** @test */
    public function it_can_filter_by_author()
    {
        $vasya = factory(Author::class)->create();
        $petya = factory(Author::class)->create();
        $art1 = factory(Article::class,3)->create();
        foreach ($art1 as $item){
            $item->authors()->attach($vasya);
        }

        $art2 = factory(Article::class,2)->create();
        foreach ($art2 as $item){
            $item->authors()->attach($petya);
        }


        $vasyaArticles = Article::getFilteredList(['author' => $vasya->id]);
        $this->assertCount(3,$vasyaArticles);

    }

    /** @test */
    public function article_can_attach_file()
    {
        $art = factory(Article::class)->create(['file_id' => null]);
        $this->assertInstanceOf(Article::class, $art);
        $this->assertNull($art->file);
        $fileName = 'example.pdf';
        $filePath = ENV('FIXTURES_DIR') .'/'.$fileName;
        file_put_contents($filePath, '');
        $art->attachFile($filePath);
        $art->refresh();
        $file  = $art->file;
        $this->assertNotNull($file);
        $this->assertInstanceOf(File::class, $file);
        $this->assertEquals($fileName, $file->filename);
        $file->delete();
    }

    /** @test */
    public function it_returns_correct_route()
    {
        $art = factory(Article::class)->create(['format' => Article::TEXT_TYPE,'file_id' => null]);
        $this->assertEquals(config('app.url').'/articles/'.$art->id, $art->route());

        $art->format = Article::PDF_TYPE;
        $art->file_id = 1;
        $art->save();
        $this->assertEquals(config('app.url').'/articles/'.$art->id, $art->route());

        $art->format = Article::LINK_TYPE;
        $art->link = 'www.somedomain.com';
        $art->save();
        $this->assertEquals('http://www.somedomain.com', $art->route());

        $art->link = 'http://www.somedomain.com';
        $art->save();
        $this->assertEquals('http://www.somedomain.com', $art->route());

        $art->link = 'https://www.somedomain.com';
        $art->save();
        $this->assertEquals('https://www.somedomain.com', $art->route());

    }

    /** @test */
    public function it_return_imgSrc()
    {
        //without ext
        $artWithImg = factory(Article::class)->create(['img' => 'my-file-test']);
        $this->assertEquals(config('app.url').'/storage/img/my-file-test.jpg', $artWithImg->imgSrc());

        //with ext
        $artWithImg = factory(Article::class)->create(['img' => 'my-file.jpg']);
        $this->assertEquals(config('app.url').'/storage/img/my-file.jpg', $artWithImg->imgSrc());

        //without filename
        $artWithoutImg = factory(Article::class)->create(['img' => null]);
        $this->assertEquals(config('app.url').'/'.config('content.article-default-img'), $artWithoutImg->imgSrc());
    }

    /** @test
     * @dataProvider articleTitles
     */
    public function it_can_return_letter($title, $letter)
    {
        $art = factory(Article::class)->create(['title' =>  $title]);
        $this->assertEquals($letter, $art->letter());
    }

    public function articleTitles(){
        return [
            ['Статья о мишке', 'С'],
            ['"Статья о мишке"', 'С'],
            ["'Статья о мишке", 'С'],
            ["'А эта статья начинается на А", 'А'],
        ];
    }


    /** @test */
    public function it_can_belongs_to_magazine()
    {
        $mag = factory(Magazine::class)->create();
        $art1 = factory(Article::class)->create(['magazine_id' => $mag->id]);
        $this->assertInstanceOf(Magazine::class, $art1->magazine);
        $this->assertTrue($art1->magazine->is($mag));
    }

    /** @test */
    public function it_can_return_bread_crumbs()
    {
        $rootTopic = factory(Topic::class)->create(['parent_topic_id' => null ]);
        $targetTopic = factory(Topic::class)->create(['parent_topic_id' => $rootTopic->id]);
        $childTopic = factory(Topic::class)->create([ 'parent_topic_id' => $targetTopic->id]);

        $article = factory(Article::class)->create(['topic_id'=>$childTopic->id]);
        $bc = $article->breadcrumbs();
        $this->assertIsArray($bc);
        foreach ($bc as $bcItem){
            $this->assertArrayHasKey('link', $bcItem);
            $this->assertArrayHasKey('title', $bcItem);
        }
    }


    /** @test */
    public function it_can_return_format_code()
    {
        $article = factory(Article::class)->create();
        $article->format = Article::LINK_TYPE;
        $article->save();
        $this->assertEquals('link', $article->formatCode());
    }

    /** @test */
    public function it_can_return_more_articles()
    {
        $topic = factory(Topic::class)->create();
        $articles = factory(Article::class, 3)->create(['topic_id' => $topic->id]);
        $more = $articles[0]->moreArticles();
        $this->assertCount(2,$more);

        $this->assertInstanceOf(Article::class, $more[0]);
    }

    /** @test */
    public function it_has_limit_count_of_more_articles()
    {
        $maxMoreArticlesCount = config('content.more-article-count');
        $topic = factory(Topic::class)->create();
        $articles = factory(Article::class, $maxMoreArticlesCount + 2)->create(['topic_id' => $topic->id]);
        $more = $articles[0]->moreArticles();
        $this->assertCount($maxMoreArticlesCount,$more);
    }

    /** @test */
    public function it_has_open_in_new_tab_method()
    {
        $bookType = factory(ContentType::class)->create(['code' => ContentType::BOOK]);
        $articleType = factory(ContentType::class)->create(['code' => ContentType::ARTICLE]);

        $art = new Article();
        $art->format = Article::PDF_TYPE;
        $this->assertTrue($art->openInNewTab());

        $art->format = Article::TEXT_TYPE;
        $this->assertFalse($art->openInNewTab());

        $art->format = Article::LINK_TYPE;
        $art->content_type_id = $articleType->id;
        $this->assertTrue($art->openInNewTab());

        $art->format = Article::LINK_TYPE;
        $art->content_type_id = $bookType->id;
        $this->assertFalse($art->openInNewTab());
    }


}
