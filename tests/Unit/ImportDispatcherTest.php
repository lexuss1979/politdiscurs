<?php

namespace Tests\Unit;

use App\Import\ImportDispatcher;
use App\Import\ImportItem;
use Iterator;
use PHPUnit\Framework\TestCase;

class ImportDispatcherTest extends TestCase
{
    /** @ test */
    public function it_can_read_file()
    {
        $path = "/Users/aleksejafanasev/Documents/Projects/Politics";
        $file = "01_Внутренняя политика.xlsx";
        $dispatcher = new ImportDispatcher($path);
        $dispatcher->loadDataFromFile($file);
        $this->assertTrue(is_array($dispatcher->getData()));
        $dispatcher->saveAsTxt('serialized-data.txt');

    }

    /** @test */
    public function itCanLoadSerializedData()
    {
        $path = "/Users/aleksejafanasev/Documents/Projects/Politics";
        $file = "serialized-data.txt";
        $dispatcher = new ImportDispatcher($path);
        $dispatcher->loadFromSerializedData($file);
        $this->assertTrue(is_array($dispatcher->getData()));
        $this->count(6, $dispatcher->getData());
    }

    /** @test */
    public function it_can_return_iterator()
    {
        $path = "/Users/aleksejafanasev/Documents/Projects/Politics";
        $file = "serialized-data.txt";
        $dispatcher = new ImportDispatcher($path);
        $dispatcher->loadFromSerializedData($file);
        $iterator = $dispatcher->getIterator();
        $this->assertInstanceOf(Iterator::class, $iterator);
        $item = $iterator->current();
        $this->assertInstanceOf(ImportItem::class, $item);
    }

    /** @test */
    public function it_can_load_dictionaries()
    {
        $path = "/Users/aleksejafanasev/Documents/Projects/Politics";
        $file = "serialized-data.txt";
        $dispatcher = new ImportDispatcher($path);
        $dispatcher->loadFromSerializedData($file);
        $filters = $dispatcher->generateFilters();
        $this->assertTrue(is_array($filters));
        $this->assertArrayHasKey('types', $filters);
        $this->assertArrayHasKey('authors', $filters);
        $this->assertArrayHasKey('regions', $filters);
        $this->assertArrayHasKey('sources', $filters);
        $this->assertArrayHasKey('years', $filters);
        $this->assertArrayHasKey('organizations', $filters);
    }

    /** @test */
    public function it_can_save_filters_to_file()
    {
        $path = "/Users/aleksejafanasev/Documents/Projects/Politics";
        $file = "serialized-data.txt";
        $dispatcher = new ImportDispatcher($path);
        $dispatcher->loadFromSerializedData($file);
        $dispatcher->saveFiltersAsTxt('filters.txt');
        $this->assertFileExists($path . "/filters.txt");

    }

    /** @test */
    public function it_can_detect_bad_links_or_file()
    {
        $path = "/Users/aleksejafanasev/Documents/Projects/Politics";
        $file = "serialized-data.txt";
        $dispatcher = new ImportDispatcher($path);
        $dispatcher->loadFromSerializedData($file);
        $failedSourced = $dispatcher->checkLinksAndFiles('files.csv');
//        $items = $dispatcher->getIterator();

//        var_dump($items->current());
//        return ;


        $this->assertTrue(is_array($failedSourced));
        $this->assertArrayHasKey("files",$failedSourced);
    }





}
