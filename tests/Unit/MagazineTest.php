<?php

namespace Tests\Unit;

use App\Article;
use App\Magazine;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MagazineTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_has_linked_articles()
    {
        $mag = factory(Magazine::class)->create();
        $art1 = factory(Article::class)->create(['magazine_id' => $mag->id]);
        factory(Article::class)->create( ['magazine_id' => $mag->id +1]);
        $this->assertCount(1, $mag->articles);
        $this->assertTrue($mag->articles[0]->is($art1));
    }

    /** @test */
    public function it_returns_correct_route()
    {
        $mag = factory(Magazine::class)->create();
        $this->assertEquals(config('app.url').'/magazines/'.$mag->id, $mag->route());

    }

    /** @test */
    public function it_return_imgSrc()
    {

        $magWithImg = factory(Magazine::class)->create([
            'img' => 'my-file.jpg'
        ]);
        $this->assertEquals(config('app.url').'/storage/img/my-file.jpg', $magWithImg->imgSrc());
        $magWithoutImg = factory(Magazine::class)->create([
            'img' => null
        ]);
        $this->assertEquals(config('app.url').'/'.config('content.article-default-img'), $magWithoutImg->imgSrc());
    }


    /** @test */
    public function it_can_return_books_to_main_page_carousel()
    {
        factory(Magazine::class, 2)->create(['main_page' => false]);
        $magMainPage = factory(Magazine::class, 3)->create(['main_page' => true]);
        $mainPage = Magazine::getListForMainPage();
        $this->assertCount(3, $mainPage);
        foreach ($mainPage as $mag){
            $this->assertTrue(in_array($mag->id,$magMainPage->pluck('id')->toArray() ));
        }
    }

    /** @test */
    public function it_returns_limited_count_of_item()
    {
        factory(Magazine::class, 5)->create(['main_page' => true]);
        config()->set('content.magazines-on-main-page',10);
        $mainPage = Magazine::getListForMainPage();
        $this->assertCount(5, $mainPage);

        config()->set('content.magazines-on-main-page',3);
        $mainPage = Magazine::getListForMainPage();
        $this->assertCount(3, $mainPage);
    }

    /** @test */
    public function it_can_return_count()
    {
        factory(Magazine::class, 3)->create(['main_page' => true]);
        factory(Magazine::class, 2)->create(['main_page' => false]);
        $this->assertEquals(5, Magazine::count());
    }

}
