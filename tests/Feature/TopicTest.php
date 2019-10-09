<?php

namespace Tests\Feature;

use App\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
