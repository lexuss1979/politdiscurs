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
}
