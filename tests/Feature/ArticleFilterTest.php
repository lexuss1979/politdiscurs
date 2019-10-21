<?php

namespace Tests\Feature;

use App\Article;
use App\ArticleFilter;
use App\Author;
use App\ContentCollection;
use App\ContentType;
use App\Region;
use App\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ArticleFilterTest extends TestCase
{
    use RefreshDatabase;

    protected $filter;
    protected $rootTopic;
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->filter = new ArticleFilter();
        $this->rootTopic = factory(Topic::class)->create(['title' => 'topic1']);
    }

    /** @test */
    public function it_return_result()
    {
        $result = $this->filter->get();
        $this->assertInstanceOf(ContentCollection::class, $result);
    }

    /** @test */
    public function get_all_articles_of_topic()
    {
        $topic2 = factory(Topic::class)->create(['title' => 'topic2']);
        factory(Article::class)->create(['title'=>'article', 'topic_id' => $this->rootTopic->id]);
        $this->assertCount(1,$this->filter->forTopic($this->rootTopic)->get()->content());
        $this->assertCount(0,$this->filter->forTopic($topic2)->get()->content());
    }

    /** @test */
    public function it_can_use_topic_id()
    {
        factory(Article::class)->create(['title'=>'article', 'topic_id' => $this->rootTopic->id]);
        $this->assertCount(1,$this->filter->forTopic($this->rootTopic->id)->get()->content());
    }


    /** @test */
    public function it_get_articles_of_all_children_topics()
    {
        $topic1 = factory(Topic::class)->create(['title' => 'topic1','parent_topic_id' => null]);
        $topic2 = factory(Topic::class)->create(['title' => 'topic2','parent_topic_id' => $this->rootTopic->id]);
        $topic3 = factory(Topic::class)->create(['title' => 'topic3','parent_topic_id' => $this->rootTopic->id]);
        factory(Article::class)->create(['title'=>'a0', 'topic_id' => $topic1->id]);
        factory(Article::class)->create(['title'=>'a1', 'topic_id' => $this->rootTopic->id]);
        factory(Article::class)->create(['title'=>'a2', 'topic_id' => $topic2->id]);
        factory(Article::class)->create(['title'=>'a3', 'topic_id' => $topic3->id]);
        $this->assertCount(3,$this->filter->forTopic($this->rootTopic)->get()->content());
    }

    /** @test */
    public function it_can_filter_for_several_topic_id()
    {
        $topic1 = factory(Topic::class)->create(['title' => 'topic1','parent_topic_id' => $this->rootTopic->id]);
        $topic2 = factory(Topic::class)->create(['title' => 'topic2','parent_topic_id' => $this->rootTopic->id]);
        $topic3 = factory(Topic::class)->create(['title' => 'topic3','parent_topic_id' => $this->rootTopic->id]);
        factory(Article::class)->create(['title'=>'a0', 'topic_id' => $topic1->id]);
        factory(Article::class)->create(['title'=>'a1', 'topic_id' => $topic2->id]);
        factory(Article::class)->create(['title'=>'a2', 'topic_id' => $topic2->id]);
        factory(Article::class)->create(['title'=>'a3', 'topic_id' => $topic3->id]);
        $this->assertCount(3,$this->filter->forTopic([$topic2, $topic3])->get()->content());
    }

    /** @test */
    public function it_can_filter_for_several_topic_id_passed_as_array_of_int()
    {
        $topic1 = factory(Topic::class)->create(['title' => 'topic1','parent_topic_id' => $this->rootTopic->id]);
        $topic2 = factory(Topic::class)->create(['title' => 'topic2','parent_topic_id' => $this->rootTopic->id]);
        $topic3 = factory(Topic::class)->create(['title' => 'topic3','parent_topic_id' => $this->rootTopic->id]);
        factory(Article::class)->create(['title'=>'a0', 'topic_id' => $topic1->id]);
        factory(Article::class)->create(['title'=>'a1', 'topic_id' => $topic2->id]);
        factory(Article::class)->create(['title'=>'a2', 'topic_id' => $topic2->id]);
        factory(Article::class)->create(['title'=>'a3', 'topic_id' => $topic3->id]);
        $this->assertCount(3,$this->filter->forTopic([$topic2->id, $topic3->id])->get()->content());
    }

    /** @test */
    public function it_can_filter_by_year()
    {
        factory(Article::class)->create(['title'=>'a1', 'topic_id' => $this->rootTopic->id, 'year' => 2019]);
        factory(Article::class)->create(['title'=>'a2', 'topic_id' => $this->rootTopic->id, 'year' => 2019]);
        factory(Article::class)->create(['title'=>'a3', 'topic_id' => $this->rootTopic->id, 'year' => 2017]);
        $this->assertCount(2,$this->filter->forTopic($this->rootTopic)->forYear(2019)->get()->content());
        $this->assertCount(1,$this->filter->forTopic($this->rootTopic)->forYear(2017)->get()->content());
    }

    /** @test */
    public function it_can_filter_by_author()
    {
        $ivan = factory(Author::class)->create(['fio' => 'Ivan']);
        $petr = factory(Author::class)->create(['fio' => 'Petr']);
        $serg = factory(Author::class)->create(['fio' => 'Serg']);
        $art1 = factory(Article::class)->create(['title'=>'a1', 'topic_id' => $this->rootTopic->id]);
        $art1->authors()->attach($ivan);
        $art2 = factory(Article::class)->create(['title'=>'a2', 'topic_id' => $this->rootTopic->id]);
        $art2->authors()->attach($ivan);
        $art2->authors()->attach($petr);
        $art3 = factory(Article::class)->create(['title'=>'a3', 'topic_id' => $this->rootTopic->id]);
        $art3->authors()->attach($ivan);
        $art3->authors()->attach($petr);
        $art3->authors()->attach($serg);

        $this->assertCount(3, $this->filter->forTopic($this->rootTopic)->forAuthor($ivan)->get()->content());
        $this->assertCount(2, $this->filter->forTopic($this->rootTopic)->forAuthor($petr)->get()->content());
        $this->assertCount(1, $this->filter->forTopic($this->rootTopic)->forAuthor($serg)->get()->content());

    }


    /** @test */
    public function it_can_filter_by_region()
    {
        $usa = factory(Region::class)->create(['name' => 'USA']);
        $europe = factory(Region::class)->create(['name' => 'Europe']);
        $russia = factory(Region::class)->create(['name' => 'Russia']);
        $art1 = factory(Article::class)->create(['title'=>'a1', 'topic_id' => $this->rootTopic->id]);
        $art1->regions()->attach($usa);
        $art2 = factory(Article::class)->create(['title'=>'a2', 'topic_id' => $this->rootTopic->id]);
        $art2->regions()->attach($usa);
        $art2->regions()->attach($europe);
        $art3 = factory(Article::class)->create(['title'=>'a3', 'topic_id' => $this->rootTopic->id]);
        $art3->regions()->attach($usa);
        $art3->regions()->attach($europe);
        $art3->regions()->attach($russia);

        $this->assertCount(3, $this->filter->forTopic($this->rootTopic)->forRegion($usa)->get()->content());
        $this->assertCount(2, $this->filter->forTopic($this->rootTopic)->forRegion($europe)->get()->content());
        $this->assertCount(1, $this->filter->forTopic($this->rootTopic)->forRegion($russia)->get()->content());

    }


    /** @test */
    public function it_can_filter_by_content_type()
    {

        factory(Article::class, 2)->create(['topic_id' => $this->rootTopic->id, 'content_type_id' => ContentType::BOOK]);
        $art1 = factory(Article::class)->create(['topic_id' => $this->rootTopic->id, 'content_type_id' => ContentType::ARTICLE]);
        $doc1 = factory(Article::class)->create(['topic_id' => $this->rootTopic->id, 'content_type_id' => ContentType::DOCUMENT]);
        factory(Article::class)->create(['topic_id' => $this->rootTopic->id, 'content_type_id' => ContentType::INFOGRAPHICS]);

        $this->assertCount(2, $this->filter->forTopic($this->rootTopic)->ofTypes(ContentType::BOOK)->get()->content());
        $articles = $this->filter->forTopic($this->rootTopic)->ofTypes(ContentType::ARTICLE)->get()->content();
        $this->assertCount(1, $articles);
        $this->assertEquals($art1->id, $articles[0]->id);
        $docs = $this->filter->forTopic($this->rootTopic)->ofTypes(ContentType::DOCUMENT)->get()->content();
        $this->assertEquals($doc1->id, $docs[0]->id);


    }



    /** @test */
    public function it_can_sort_by_year()
    {
        factory(Article::class)->create(['title'=>'a1', 'topic_id' => $this->rootTopic->id, 'year' => 2008]);
        factory(Article::class)->create(['title'=>'a2', 'topic_id' => $this->rootTopic->id, 'year' => 1980]);
        factory(Article::class)->create(['title'=>'a3', 'topic_id' => $this->rootTopic->id, 'year' => 2010]);
        $result = $this->filter->forTopic($this->rootTopic)->get()->content();
        $this->assertEquals(2008,$result[0]->year);
        $result = $this->filter->forTopic($this->rootTopic)->orderByYear()->get()->content();
        $this->assertEquals(2010,$result[0]->year);
        $this->assertEquals(2008,$result[1]->year);
        $this->assertEquals(1980,$result[2]->year);


    }

    /** @test */
    public function it_can_sort_by_author()
    {
        factory(Article::class)->create(['title'=>'a1', 'topic_id' => $this->rootTopic->id, 'authors_string' => 'Леонов О.Н.']);
        factory(Article::class)->create(['title'=>'a2', 'topic_id' => $this->rootTopic->id, 'authors_string' => 'Семенов Б.Н.']);
        factory(Article::class)->create(['title'=>'a3', 'topic_id' => $this->rootTopic->id, 'authors_string' => 'Алтухов С.А.']);
        $result = $this->filter->forTopic($this->rootTopic)->get()->content();
        $this->assertEquals('Леонов О.Н.',$result[0]->authors_string);
        $result = $this->filter->forTopic($this->rootTopic)->orderByAuthor()->get()->content();
        $this->assertEquals('Алтухов С.А.',$result[0]->authors_string);
        $this->assertEquals('Леонов О.Н.',$result[1]->authors_string);
        $this->assertEquals('Семенов Б.Н.',$result[2]->authors_string);
    }

    /** @test */
    public function it_can_sort_by_title()
    {
        factory(Article::class)->create(['title'=>'Статья на С', 'topic_id' => $this->rootTopic->id]);
        factory(Article::class)->create(['title'=>'Статья на А', 'topic_id' => $this->rootTopic->id]);
        factory(Article::class)->create(['title'=>'Статья на П', 'topic_id' => $this->rootTopic->id]);
        $result = $this->filter->forTopic($this->rootTopic)->get()->content();
        $this->assertEquals('Статья на С',$result[0]->title);
        $result = $this->filter->forTopic($this->rootTopic)->orderByTitle()->get()->content();
        $this->assertEquals('Статья на А',$result[0]->title);
        $this->assertEquals('Статья на П',$result[1]->title);
        $this->assertEquals('Статья на С',$result[2]->title);
    }


    /** @test */
    public function it_returns_filters()
    {
        factory(Article::class, 10)->create(['topic_id' => $this->rootTopic->id]);
        $result = $this->filter->forTopic($this->rootTopic)->get();
        $this->assertTrue(is_array($result->filters()));
        $this->assertArrayHasKey('authors', $result->filters());
        $this->assertArrayHasKey('years', $result->filters());
        $this->assertArrayHasKey('regions', $result->filters());
        $this->assertArrayHasKey('content_types', $result->filters());
        $this->assertArrayHasKey('topics', $result->filters());
        $this->assertArrayHasKey('organisations', $result->filters());
    }

    /** @test */
    public function it_returns_correct_authors_filter()
    {
        $ivan = factory(Author::class)->create(['fio' => 'Ivan']);
        $petr = factory(Author::class)->create(['fio' => 'Petr']);
        $serg = factory(Author::class)->create(['fio' => 'Serg']);
        $art1 = factory(Article::class)->create(['title'=>'a1', 'topic_id' => $this->rootTopic->id]);
        $art1->authors()->attach($ivan);
        $art2 = factory(Article::class)->create(['title'=>'a2', 'topic_id' => $this->rootTopic->id]);
        $art2->authors()->attach($ivan);
        $art2->authors()->attach($petr);
        $art3 = factory(Article::class)->create(['title'=>'a3', 'topic_id' => $this->rootTopic->id]);
        $art3->authors()->attach($serg);

        $filters = $this->filter->forTopic($this->rootTopic)->get()->filters();
        $this->assertFilterHasItem(['id' => $ivan->id, 'fio'=> $ivan->fio], $filters['authors']);
        $this->assertFilterHasItem(['id' => $petr->id, 'fio'=> $petr->fio], $filters['authors']);
        $this->assertFilterHasItem(['id' => $serg->id, 'fio'=> $serg->fio], $filters['authors']);
        $this->assertCount(3, $filters['authors']);

        $art2->authors()->detach($petr);
        $filters = $this->filter->forTopic($this->rootTopic)->get()->filters();
        $this->assertCount(2, $filters['authors']);
        $this->assertFilterHasnotItem(['id' => $petr->id, 'fio'=> $petr->fio], $filters['authors']);

    }

    /** @test */
    public function it_returns_region_filter()
    {
        $usa = factory(Region::class)->create(['name' => 'USA']);
        $europe = factory(Region::class)->create(['name' => 'Europe']);
        $russia = factory(Region::class)->create(['name' => 'Russia']);
        $art1 = factory(Article::class)->create(['title'=>'a1', 'topic_id' => $this->rootTopic->id]);
        $art1->regions()->attach($usa);
        $art1->regions()->attach($russia);
        $art2 = factory(Article::class)->create(['title'=>'a2', 'topic_id' => $this->rootTopic->id]);
        $art2->regions()->attach($usa);
        $art2->regions()->attach($europe);

        $filters = $this->filter->forTopic($this->rootTopic)->get()->filters();
        $this->assertCount(3, $filters['regions']);
        $this->assertFilterHasItem(['id' => $usa->id, 'name'=> $usa->name], $filters['regions']);
        $this->assertFilterHasItem(['id' => $europe->id, 'name'=> $europe->name], $filters['regions']);
        $this->assertFilterHasItem(['id' => $russia->id, 'name'=> $russia->name], $filters['regions']);

        $art2->regions()->detach($europe);
        $filters = $this->filter->forTopic($this->rootTopic)->get()->filters();
        $this->assertCount(2, $filters['regions']);
        $this->assertFilterHasnotItem(['id' => $europe->id, 'name'=> $europe->name], $filters['regions']);

        $art1->regions()->detach($usa);
        $this->assertCount(2, $filters['regions']);
        $this->assertFilterHasItem(['id' => $usa->id, 'name'=> $usa->name], $filters['regions']);

    }

    /** @test */
    public function it_returns_years_filter()
    {
        factory(Article::class,3)->create(['topic_id' => $this->rootTopic->id, 'year' => 2008]);
        factory(Article::class,2)->create(['topic_id' => $this->rootTopic->id, 'year' => 1980]);
        $art = factory(Article::class)->create(['topic_id' => $this->rootTopic->id, 'year' => 2010]);
        $filters = $this->filter->forTopic($this->rootTopic)->get()->filters();
        $this->assertCount(3, $filters['years']);
        $this->assertFilterHasItem(2010, $filters['years']);

        $art->delete();
        $filters = $this->filter->forTopic($this->rootTopic)->get()->filters();
        $this->assertCount(2, $filters['years']);
        $this->assertFilterHasNotItem(2010, $filters['years']);

    }


    /** @test */
    public function content_has_paging()
    {
        factory(Article::class,37)->create(['topic_id' => $this->rootTopic->id]);
        $result = $this->filter->forTopic($this->rootTopic)->withPaging(15)->get();
        $paging = $result->paging();
        $this->assertCount(15,$result->content());
        $this->assertArrayHasKey('per_page',$paging);
        $this->assertEquals(15, $paging['per_page']);
        $this->assertArrayHasKey('current',$paging);
        $this->assertEquals(1, $paging['current']);
        $this->assertArrayHasKey('total',$paging);
        $this->assertEquals(3, $paging['total']);
        $this->assertArrayHasKey('items_count',$paging);
        $this->assertEquals(37, $paging['items_count']);

        $result = $this->filter->forTopic($this->rootTopic)->withPaging(15,2)->get();
        $this->assertCount(15,$result->content());

        $result = $this->filter->forTopic($this->rootTopic)->withPaging(15,3)->get();
        $this->assertCount(7,$result->content());
    }




    protected function assertFilterHasItem($item,$filter)
    {
        foreach ($filter as $filterItem){
            if($filterItem == $item) {
                $this->assertTrue(true);
                return true;
            }
        }
        echo "\nItem was not found in filter\n";
        echo "expected item:\n";
        var_dump($item);
        echo "filter:\n";
        var_dump($filter);
        $this->fail();
    }

    protected function assertFilterHasNotItem($item,$filter)
    {
        foreach ($filter as $filterItem){
            if($filterItem == $item) {
                echo "\nItem was unexpectedly found in filter\n";
                echo "item:\n";
                var_dump($item);
                echo "filter:\n";
                var_dump($filter);
                $this->fail();
                return true;
            }
        }
        $this->assertTrue(true);
    }




}
