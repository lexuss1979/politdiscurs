<?php

namespace Tests\Feature;

use App\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TopicTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_can_find_topic_by_name()
    {
        $topic = Topic::create([
            'title' => 'testTitle',
            'parent_topic_id' => 4

        ]);
        $findResult = Topic::getOrCreate('testTitle',4);
        $this->assertInstanceOf(Topic::class, $findResult);
        $this->assertTrue($findResult->is($topic));

    }

    /** @test */
    public function it_can_create_topic_by_name()
    {
        $topic = Topic::create([
            'title' => 'testTitle',
            'parent_topic_id' => 4

        ]);
        $findResult = Topic::getOrCreate('testTitle_1',4);
        $this->assertInstanceOf(Topic::class, $findResult);
        $this->assertFalse($findResult->is($topic));
        $this->assertEquals('testTitle_1', $findResult->title);
        $this->assertEquals(4,$findResult->parent_topic_id);


    }

    /** @test */
    public function it_can_return_a_hierarchy()
    {
        $topic1 = factory(Topic::class)->create();
        $topic1_1 = factory(Topic::class)->create();
        $topic2 = factory(Topic::class)->create(['parent_topic_id'=>$topic1->id]);
        $topic3 = factory(Topic::class)->create(['parent_topic_id'=>$topic2->id]);
        $hierarchy = Topic::getHierarchy();
        $this->assertInstanceOf(Collection::class, $hierarchy);
        $this->assertCount(2, $hierarchy);
        $this->assertArrayHasKey('id',$hierarchy[0]);
        $this->assertArrayHasKey('title',$hierarchy[0]);
        $this->assertArrayHasKey('children',$hierarchy[0]);
        $this->assertArrayHasKey('level',$hierarchy[0]);
        $topic1fromHierarchy  = $this->getArrayElementById($hierarchy, $topic1->id);
        $topic1_1fromHierarchy  = $this->getArrayElementById($hierarchy, $topic1_1->id);
        $this->assertInstanceOf(Topic::class,$topic1fromHierarchy);
        $this->assertCount(1,$topic1fromHierarchy['children']);
        $this->assertInstanceOf(Topic::class,$topic1_1fromHierarchy);
        $this->assertCount(0,$topic1_1fromHierarchy['children']);
        $this->assertEquals($topic2->id,$topic1fromHierarchy['children'][0]['id']);
        $this->assertCount(1,$topic1fromHierarchy['children'][0]['children']);
        $this->assertEquals($topic3->id,$topic1fromHierarchy['children'][0]['children'][0]['id']);
    }

    protected function getArrayElementById($hierarchy, $id){
        foreach ($hierarchy as $item){
            if($item['id']  == $id) return $item;
        }
        return false;
    }




}
