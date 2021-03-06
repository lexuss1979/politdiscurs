<?php

namespace Tests\Unit\Helpers;

use App\Helpers\PaginatedCollection;
use Tests\TestCase;

class PaginatedCollectionTest extends TestCase
{

    private $collection;
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->collection = new PaginatedCollection([]);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGetUrl($page, $baseUrl, $expected)
    {
         $this->assertEquals($expected, $this->collection->getUrl($baseUrl, $page));
    }

    public function dataProvider(){
        return [
            [2, '/topics/2','/topics/2?page=2'],
            [2, '/topics/2?topics=[1,2]','/topics/2?topics=[1,2]&page=2'],
            [2, '/topics/2?topics=[1,2]&page=30','/topics/2?topics=[1,2]&page=2']
        ];
    }
}
