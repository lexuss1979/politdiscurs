<?php


namespace App\Http\Controllers;


use App\Article;
use App\Author;
use App\ContentType;
use App\Import\ImportDispatcher;
use App\Import\ImportItem;
use App\Organisation;
use App\Region;
use App\Source;
use App\Topic;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PhpOffice\PhpWord\Reader\ODText\Content;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateFilters()
    {
        $path = "/Users/aleksejafanasev/Documents/Projects/Politics";
        $file = "serialized-data.txt";
        $dispatcher = new ImportDispatcher($path);
        $dispatcher->loadFromSerializedData($file);
        $filters = $dispatcher->generateFilters();
        Author::refreshFilterData($filters['authors']);
        Organisation::refreshFilterData($filters['organizations']);
        Region::refreshFilterData($filters['regions']);
        Source::refreshFilterData($filters['sources']);

        ContentType::truncate();
        ContentType::create(['code' => ContentType::ARTICLE, 'name' => 'Статьи']);
        ContentType::create(['code' => ContentType::BOOK, 'name' => 'Книги']);
        ContentType::create(['code' => ContentType::DOCUMENT, 'name' => 'Документы']);
        ContentType::create(['code' => ContentType::INFOGRAPHICS, 'name' => 'Инфографика']);


        return Response(['result' => $filters['authors']]);
    }


    public function createTopics(){
        Topic::truncate();
        $this->createInnerTopics();
        $this->createOuterTopics();
    }

    private function createInnerTopics(){
        $inner = Topic::create([
            'title' => "Международные отношения",
            'parent_topic_id' => null
        ]);
        $this->addTopics($inner->id,[
            ["Государство","Kollage_007.png","rgba(188, 108, 80, 0.25);"],
            ["Политика и экономика","Kollage_008.png","rgba(114, 176, 79, 0.25);"],
            ["Гражданское общество","Kollage_011.png","rgba(159, 145, 139, 0.25);"],
            ["Демократия и выборы","Kollage_009.png","rgba(176, 157, 79, 0.25);"],
            ["Федерализм и регионы","Kollage_010.png","rgba(176, 79, 94, 0.25);"],
            ["Культура и идеология","Kollage_012.png","rgba(176, 123, 79, 0.25);"],
        ]);
    }
    private function createOuterTopics(){
        $outer = Topic::create([
            'title' => "Международные отношения",
            'parent_topic_id' => null
        ]);
        $this->addTopics($outer->id,[
            ["Миропорядок","Kollage_001.png","rgba(181, 130, 165, 0.25);"],
            ["Международная безопасность","Kollage_003.png","rgba(79, 176, 153, 0.25);"],
            ["Внешняя политика России","Kollage_004.png","rgba(107, 79, 176, 0.25);"],
            ["История международных отношений","Kollage_005.png","rgba(162, 162, 162, 0.25);"],
            ["Международные организации","Kollage_002.png","rgba(79, 106, 176, 0.25);"],
            ["Теория межденародных отношений","Kollage_006.png","rgba(79, 156, 176, 0.25);"],
        ]);
    }

    private function addTopics($parentId, $data){
        foreach ($data as $item) {
            $outer = Topic::create([
                'title' => $item[0],
                'parent_topic_id' => $parentId,
                'img' => $item[1],
                'bgcolor' => $item[2],
            ]);
        }
    }

    public function importContent()
    {
        $this->updateFilters();
        $this->createTopics();
        $path = "/Users/aleksejafanasev/Documents/Projects/Politics";
        $file = "serialized-data.txt";
        $dispatcher = new ImportDispatcher($path);
        $dispatcher->loadFromSerializedData($file);
        $filters = $dispatcher->generateFilters();
        $items = $dispatcher->getIterator();

        $log = new Logger('import');
        $log->pushHandler(new StreamHandler($path.'/import.log', Logger::ERROR));

        $counter = 0;
        foreach ($items as $item){
            $counter ++;
            try{
                $item->storeToDB(1,$path.'/files');
                $log->info('['.$counter.'] Import success [title='.$item->name().']');
            } catch (\Exception $e){
                $log->error('['.$counter.'] Import failed [title='.$item->name().']',['error'=>substr($e->getMessage(),0,500).'...'] );
            }
//            die();

        }
    }





}
