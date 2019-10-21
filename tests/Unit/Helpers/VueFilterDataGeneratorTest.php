<?php

namespace Tests\Unit\Helpers;

use App\Author;
use App\ContentType;
use App\Organisation;
use App\Region;
use App\Topic;
use App\Helpers\VueFilterDataGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class VueFilterDataGeneratorTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_perform_authors()
    {
        $authors = factory(Author::class, 3)->create();
        $request = new Request(['author' => $authors[2]->id], [], []);
        $filters = [
            'authors' => [$authors[0]->id, $authors[2]->id]
        ];
        $instance = new VueFilterDataGenerator($request, $filters);
        $vueData = $instance->getJSON();
        $this->assertJson($vueData);
        $arr = json_decode($vueData, true);

        $this->assertArrayHasKey('authors', $arr);
        $this->assertIsArray($arr['authors']);
        $this->assertArrayHasItem([
            'id' => $authors[0]->id,
            'title' => $authors[0]->fio,
            'on' => false], $arr['authors']);
        $this->assertArrayHasItem([
            'id' => $authors[2]->id,
            'title' => $authors[2]->fio,
            'on' => true], $arr['authors']);
        $this->assertCount(2, $arr['authors']);

    }

    protected function assertArrayHasItem($needle, $arr)
    {
        foreach ($arr as $item) {
            if ($item == $needle) return $this->assertTrue(true);
        }
        $this->fail('cannot find array ' . var_export($needle) . ' in array' . var_export($arr));
    }

    /** @test */
    public function it_perform_topics()
    {
        $topics = factory(Topic::class, 3)->create();
        $request = new Request([
            'topics' => [$topics[0]->id]
        ], [], []);
        $filters = [
            'topics' => [$topics[0]->id, $topics[2]->id]
        ];
        $instance = new VueFilterDataGenerator($request, $filters);
        $arr = json_decode($instance->getJSON(), true);

        $this->assertArrayHasKey('topics', $arr);
        $this->assertIsArray($arr['topics']);
        $this->assertArrayHasItem([
            'id' => $topics[0]->id,
            'title' => $topics[0]->title,
            'on' => true], $arr['topics']);
        $this->assertArrayHasItem([
            'id' => $topics[2]->id,
            'title' => $topics[2]->title,
            'on' => false], $arr['topics']);
        $this->assertCount(2, $arr['topics']);
    }

    /** @test */
    public function it_perform_reg()
    {
        $regions = factory(Region::class, 3)->create();
        $request = new Request([
            'reg' => $regions[1]->id
        ], [], []);
        $filters = [
            'regions' => [$regions[1]->id, $regions[2]->id]
        ];
        $instance = new VueFilterDataGenerator($request, $filters);
        $arr = json_decode($instance->getJSON(), true);

        $this->assertArrayHasKey('regions', $arr);
        $this->assertIsArray($arr['regions']);
        $this->assertArrayHasItem([
            'id' => $regions[1]->id,
            'title' => $regions[1]->name,
            'on' => true], $arr['regions']);
        $this->assertArrayHasItem([
            'id' => $regions[2]->id,
            'title' => $regions[2]->name,
            'on' => false], $arr['regions']);
        $this->assertCount(2, $arr['regions']);
    }

    /** @test */
    public function it_perform_content_types()
    {

        $contentTypes = factory(ContentType::class, 4)->create();

        $request = new Request([], [], []);
        $filters = [
            'content_types' => [$contentTypes[0]->id, $contentTypes[1]->id, $contentTypes[2]->id, $contentTypes[3]->id,]
        ];
        $instance = new VueFilterDataGenerator($request, $filters);
        $arr = json_decode($instance->getJSON(), true);

        $this->assertArrayHasKey('content_types', $arr);
        $this->assertIsArray($arr['content_types']);
        foreach ($contentTypes as $ctype) {
            $this->assertArrayHasItem([
                'id' => $ctype->id,
                'title' => $ctype->name,
                'on' => true], $arr['content_types']);
        }

        $request = new Request([
            'types' => [$contentTypes[2]->id, $contentTypes[0]->id]
        ], [], []);
        $instance = new VueFilterDataGenerator($request, $filters);
        $arr = json_decode($instance->getJSON(), true);
        $enabledKeys = [2, 0];
        foreach ($contentTypes as $key => $ctype) {
            $this->assertArrayHasItem([
                'id' => $ctype->id,
                'title' => $ctype->name,
                'on' => in_array($key, $enabledKeys)], $arr['content_types']);
        }
    }

     /** @test */
    public function it_perform_organisations()
    {
        $orgs = factory(Organisation::class,3)->create();
        $request = new Request(['org' => $orgs[2]->id],[],[]);
        $filters = [
            'organisations' => [$orgs[0]->id, $orgs[2]->id]
        ];
        $instance = new VueFilterDataGenerator($request, $filters);
        $arr = json_decode($instance->getJSON(), true);

        $this->assertArrayHasKey('organisations', $arr);
        $this->assertIsArray($arr['organisations']);
        $this->assertArrayHasItem([
            'id' => $orgs[0]->id,
            'title' => $orgs[0]->name,
            'on' => false], $arr['organisations']);
        $this->assertArrayHasItem([
            'id' => $orgs[2]->id,
            'title' => $orgs[2]->name,
            'on' => true], $arr['organisations']);
        $this->assertCount(2,$arr['organisations']);

    }


}
