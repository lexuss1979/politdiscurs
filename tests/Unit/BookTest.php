<?php

namespace Tests\Unit;

use App\Article;
use App\Book;
use App\ContentType;
use App\Http\Controllers\ServiceController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $sc = new ServiceController();
        $sc->createContentTypes();
    }

    /** @test */
    public function it_can_return_books_to_main_page_carousel()
    {
        factory(Article::class, 1)->create(['content_type_id' => ContentType::articleTypeID(), 'main_page' => true]);
        $booksMainPage = factory(Article::class, 2)->create(['content_type_id' => ContentType::bookTypeID(), 'main_page' => true]);
        $booksNotMainPage = factory(Article::class, 3)->create(['content_type_id' => ContentType::bookTypeID(), 'main_page' => false]);
        $mainPage = Book::getListForMainPage();
        $this->assertCount(2, $mainPage);
        foreach ($mainPage as $book){
            $this->assertTrue(in_array($book->id,$booksMainPage->pluck('id')->toArray() ));
        }


    }

    /** @test */
    public function it_returns_limited_count_of_item()
    {
        factory(Article::class, 1)->create(['content_type_id' => ContentType::articleTypeID(), 'main_page' => true]);
        factory(Article::class, 5)->create(['content_type_id' => ContentType::bookTypeID(), 'main_page' => true]);
        config()->set('content.books-on-main-page',10);
        $mainPage = Book::getListForMainPage();
        $this->assertCount(5, $mainPage);

        config()->set('content.books-on-main-page',3);
        $mainPage = Book::getListForMainPage();
        $this->assertCount(3, $mainPage);
    }

    /** @test */
    public function it_can_return_count()
    {
        factory(Article::class, 3)->create(['content_type_id' => ContentType::bookTypeID(), 'main_page' => true]);
        factory(Article::class, 3)->create(['content_type_id' => ContentType::bookTypeID(), 'main_page' => false]);
        factory(Article::class, 3)->create(['content_type_id' => ContentType::articleTypeID(), 'main_page' => true]);
        $this->assertEquals(6, Book::count());
    }

}
