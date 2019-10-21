<?php

namespace Tests\Feature;

use App\Article;
use App\ContentCollection;
use App\Search;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    protected $articleData;
    protected $article;
    protected $search;

    protected function setUp(): void
    {
        parent::setUp();
        $this->articleData = [
            'title' => 'My title',
            'annotation' => 'simple text annotation',
            'year' => 2010,
            'authors_string' => 'Иванов В.А., Петров С.А.'
        ];
        $this->article = factory(Article::class)->create( $this->articleData);
        $this->search = new Search();
        $this->search->addToIndex($this->article);
    }

    use RefreshDatabase;
    /** @test */
    public function it_can_add_to_index()
    {
        $this->assertDatabaseHas('search',
            [
                'text' => implode(Search::DELIMITER, $this->articleData),
                'article_id' => $this->article->id
            ]);
    }

    /** @test */
    public function it_can_search_bi_title()
    {
        $arts = factory(Article::class,10)->create();
        foreach ($arts as $art) {
            $this->search->addToIndex($art);
        }
        $result = $this->search->do('My title');
        $this->assertInstanceOf(ContentCollection::class, $result);
        $this->assertCount(1, $result->content());
        $this->assertEquals('My title', $result->content()[0]['title']);
    }

    /** @test */
    public function it_can_search_by_year()
    {
        $arts2019 = $this->addArticles(5, ['year' => 2019]);
        $arts1979 = $this->addArticles(3, ['year' => 1979]);
        $result2019 = $this->search->do('2019');
        $result1979 = $this->search->do('1979');
        $this->assertCount(5, $result2019->content());
        $this->assertCount(3, $result1979->content());
    }

    /** @test */
    public function it_can_search_by_annotation()
    {
        $this->addArticles(5, ['annotation' => 'Some text with mark ANN1']);
        $this->addArticles(3, ['annotation' => 'Some text with mark ANN2']);

        $this->assertCount(8, $this->search->do('Some text')->content());
        $this->assertCount(3, $this->search->do('mark ANN2')->content());
        $this->assertCount(5, $this->search->do('mark ANN1')->content());

    }

    /** @test */
    public function it_can_search_by_author()
    {
        $this->addArticles(5, ['authors_string' => 'Толстой Л.Н.']);
        $this->addArticles(3, ['authors_string' => 'Толстой Л.Н., Гоголь Н.В.']);

        $this->assertCount(8, $this->search->do('Толстой')->content());
        $this->assertCount(3, $this->search->do('Гоголь')->content());
        $this->assertCount(0, $this->search->do('Достоевский')->content());

    }

    /** @test */
    public function it_return_result_with_paging()
    {
        $this->addArticles(10, ['authors_string' => 'Толстой Л.Н.']);
        $result = $this->search->withPaging(3,2)->do('Толстой');
        $this->assertCount(3, $result->content());
        $paging = $result->paging();
        $this->assertEquals(3, $paging['per_page']);
        $this->assertEquals(4, $paging['total']);
        $this->assertEquals(10, $paging['items_count']);
        $this->assertEquals(2, $paging['current']);
    }

    protected function addArticles($count, $data){
        $arts = factory(Article::class,$count)->create($data);
        foreach ($arts as $art) {
            $this->search->addToIndex($art);
        }
        return $arts;
    }
}
