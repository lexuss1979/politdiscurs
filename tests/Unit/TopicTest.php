<?php

namespace Tests\Unit;

use App\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class TopicTest extends \Tests\TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_or_create()
    {
        $topic1 = Topic::create(['title' => 'First Topic', 'parent_topic_id' => null]);
        $testTopic = Topic::getOrCreate('First Topic', null);
        $this->assertEquals($topic1->id, $testTopic->id);

        $testTopic = Topic::getOrCreate('First Topic', $topic1->id);
        $this->assertNotEquals($topic1->id, $testTopic->id);
        $this->assertEquals( $testTopic->parent_topic_id, $topic1->id);

        $topic2 = Topic::getOrCreate('Second Topic', $topic1->id);
        $this->assertNotEquals($topic1->id, $testTopic->id);
        $this->assertEquals( $testTopic->parent_topic_id, $topic1->id);

        $testTopic = Topic::getOrCreate('Second Topic', $topic1->id);
        $this->assertEquals($topic2->id, $testTopic->id);

    }

    /** @test */
    public function it_can_get_parent()
    {
        $topic1 = Topic::create(['title' => 'First Topic', 'parent_topic_id' => null]);
        $testTopic = Topic::getOrCreate('First Topic', $topic1->id);
        $this->assertTrue($testTopic->parent()->is($topic1));
    }

    /** @test */
    public function it_can_return_child_topics()
    {
        $topic1 = Topic::create(['title' => 'First Topic', 'parent_topic_id' => null]);
        $topic2 = Topic::create(['title' => 'Second Topic', 'parent_topic_id' => $topic1->id]);
        $topic3 = Topic::create(['title' => 'Third Topic', 'parent_topic_id' => $topic1->id]);
        $children = $topic1->children();
        $this->assertCount(2, $children);
        $this->assertEquals('Second Topic', $children[0]->title);
        $this->assertEquals('Third Topic', $children[1]->title);
    }

    /** @test */
    public function it_can_detect_if_children_exists()
    {
        $topic1 = Topic::create(['title' => 'First Topic', 'parent_topic_id' => null]);
        $this->assertFalse($topic1->hasChildren());
        $topic2 = Topic::create(['title' => 'Second Topic', 'parent_topic_id' => $topic1->id]);
        $this->assertTrue($topic1->hasChildren());
    }

    /** @test */
    public function it_can_return_children_id_array()
    {
        $topic1 = Topic::create(['title' => 'First Topic', 'parent_topic_id' => null]);
        $topic2 = Topic::create(['title' => 'Second Topic', 'parent_topic_id' => $topic1->id]);
        $topic3 = Topic::create(['title' => 'Third Topic', 'parent_topic_id' => $topic1->id]);
        $childrenArr = $topic1->getChildrenIdArray();
        $this->assertTrue(is_array($childrenArr));
        $this->assertTrue(in_array($topic2->id, $childrenArr));
        $this->assertTrue(in_array($topic3->id, $childrenArr));
    }
}
