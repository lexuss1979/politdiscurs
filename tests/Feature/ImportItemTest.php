<?php

namespace Tests\Feature;

use App\Article;
use App\Import\ImportItem;
use App\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_to_db_and_generate_html()
    {
        $rootTopic = Topic::create(['title'=>'RootTopic','parent_topic_id'=>null]);
        $data = ['1','II_Title','doc','Topic3Level','Annotation','Ivanov, Sidorov ','SourceName','www.link.com',
            'PostOffice','','2019','Europe, America','test','',false, false, '','','MainTopic'];
        $art = $this->store($data, $rootTopic);
        $this->assertInstanceOf(Article::class, $art);
        $this->assertEquals('II_Title',$art->title);
        $this->assertEquals('Topic3Level',$art->topic->title);
        $this->assertEquals('MainTopic',$art->topic->parent()->title);
        $this->assertEquals('RootTopic',$art->topic->parent()->parent()->title);
        $this->assertEquals('Annotation',$art->annotation);

        $this->assertCount(2,$art->authors);
        $this->assertEquals('Ivanov',$art->authors[0]->fio);
        $this->assertEquals('Sidorov',$art->authors[1]->fio);

        $this->assertEquals('SourceName',$art->source->name);
        $this->assertEquals('www.link.com',$art->link);

        $this->assertCount(1,$art->organisations);
        $this->assertEquals('PostOffice',$art->organisations[0]->name);

        $this->assertEquals('2019',$art->year);

        $this->assertCount(2,$art->regions);

        $this->assertEquals('Europe',$art->regions[0]->name);
        $this->assertEquals('America',$art->regions[1]->name);

        $this->assertNotNull($art->html);
        $this->assertStringContainsString('<h1>',$art->html);
    }

    /** @test */
    public function it_can_store_to_db_and_link_file()
    {
        $rootTopic = Topic::create(['title'=>'RootTopic','parent_topic_id'=>null]);
        $data = ['1','II_Title','pdf','Topic3Level','Annotation','Ivanov, Sidorov ','SourceName','www.link.com',
            'PostOffice','','2019','Europe, America','article','',false, false, '','','MainTopic'];

        $expectedFile = config('filesystems.disks.public.files').'/article.pdf';

        $art = $this->store($data, $rootTopic);
        $this->assertNotNull($art->file);
        $this->assertEquals('article.pdf',$art->file->filename);
        $this->assertFileExists($expectedFile);
        unlink($expectedFile);
    }

    private function store($data, Topic $rootTopic){
        // 0 - №
        // 1 - Название
        // 2 - Формат произведения
        // 3 - 	Подраздел
        // 4 - 	Аннотация
        // 5 -	Автор
        // 6 -	Источник
        // 7 - 	Ссылка на сайт издательства/ института
        // 8 -	Организация
        // 9 -	Ссылка на статью
        // 10 -	Год издания
        // 11 -	Регион мира
        // 12 - Файл статьи
        // 13 -	Обложка
        // 14 -	Журнал
        // 15 -	Книга
        // 16 -	Примечание
        // 17 - Раздел
        $ii = new ImportItem($data);
        return $ii->storeToDB($rootTopic->id,ENV('FIXTURES_DIR'));
    }
}
