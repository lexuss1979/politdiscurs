<?php


namespace App\Http\Controllers;


use App\Article;
use App\Author;
use App\ContentType;
use App\Import\ImportDispatcher;
use App\Import\ImportItem;
use App\Import\MagazineImporter;
use App\Organisation;
use App\Region;
use App\Source;
use App\Topic;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PhpOffice\PhpWord\Reader\ODText\Content;

class ServiceController extends Controller
{
    protected $log;
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

    protected function importInnerPolitics(){
        $INNER_TOPIC_ID = 1;
        $path = "/Users/aleksejafanasev/Documents/Projects/Politics/Inner/";
        $file = "01_Внутренняя политика.xlsx";
        $dispatcher = new ImportDispatcher($path);
        $dispatcher->loadDataFromFile($file);
        $dispatcher->saveAsTxt('inner-politics-data.txt');
        $this->processItems($dispatcher->getIterator(),$INNER_TOPIC_ID, $path);
    }

    protected function importOuterPolitics(){
        $OUTER_TOPIC_ID = 2;
        $path = "/Users/aleksejafanasev/Documents/Projects/Politics/Outer/";
        $file = "02_Международная политика.xlsx";
        $dispatcher = new ImportDispatcher($path);
        $dispatcher->loadDataFromFile($file);
        $dispatcher->saveAsTxt('outer-politics-data.txt');
        $this->processItems($dispatcher->getIterator(),$OUTER_TOPIC_ID, $path);
    }

    protected function processItems($items, $rootTopicId, $path){
        $counter = 0;
        foreach ($items as $item){
            $counter ++;
            try{
                $item->storeToDB($rootTopicId,$path.'/files');
                $this->log->info('['.$counter.'] Import success [title='.$item->name().']');
            } catch (\Exception $e) {
                $this->log->error('[' . $counter . '] Import failed [title=' . $item->name() . ']', ['error' => substr($e->getMessage(), 0, 500) . '...']);
            }

        }
    }

    public function importContent()
    {
        $path = "/Users/aleksejafanasev/Documents/Projects/Politics";
        $this->importMagazines();
        $this->updateFilters();
        $this->createTopics();

        $this->log = new Logger('import');
        $this->log->pushHandler(new StreamHandler($path.'/import.log', Logger::ERROR));
        $this->importInnerPolitics();
        $this->importOuterPolitics();

    }


    public function importMagazines()
    {
        $importer = new MagazineImporter("/Users/aleksejafanasev/Documents/Projects/Politics/Журналы","Список журналов.xlsx");
        $importer->do();
    }





}
