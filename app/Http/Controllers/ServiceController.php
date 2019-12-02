<?php


namespace App\Http\Controllers;


use App\Article;
use App\Author;
use App\ContentType;
use App\Helpers\SpreadsheetReader;
use App\Import\ContentImporter;
use App\Import\ImportDispatcher;
use App\Import\ImportItem;
use App\Import\ImportObjectIterator;
use App\Import\MagazineImporter;
use App\Organisation;
use App\Region;
use App\Search;
use App\Source;
use App\Topic;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PhpOffice\PhpWord\Reader\ODText\Content;
use stdClass;

class ServiceController extends Controller
{
    protected $log;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateFilters($filters)
    {

        Author::refreshFilterData($filters['authors']);
        Organisation::refreshFilterData($filters['orgs']);
        Region::refreshFilterData($filters['regions']);
        Source::refreshFilterData($filters['sources']);

        $this->createContentTypes();


        return Response(['result' => $filters['authors']]);
    }




    public function createTopics(){
        Topic::truncate();
        $this->createInnerTopics();
        $this->createOuterTopics();
    }

    private function createInnerTopics(){
        $inner = Topic::create([
            'title' => "Внутренняя политика",
            'parent_topic_id' => null,
            'code' => Topic::INNER_CODE
        ]);
        $this->addTopics($inner->id,[
            ["Государство","Kollage_007.png","#bc6c50","#DC9C6A",7],
            ["Политика и экономика","Kollage_008.png","#a14fb0","#B67DAE",8],
            ["Гражданское общество","Kollage_011.png","#7fb04f","#CD7794",11],
            ["Демократия и выборы","Kollage_009.png","#4fb0ad","#417038",9],
            ["Федерализм и регионы","Kollage_010.png","#a2707c","#4CC4A8",10],
            ["Культура и идеология","Kollage_012.png","#4fb065","#63A689",12],
        ]);
    }
    private function createOuterTopics(){
        $outer = Topic::create([
            'title' => "Международные отношения",
            'parent_topic_id' => null,
            'code' => Topic::OUTER_CODE
        ]);
        $this->addTopics($outer->id,[
            ["Миропорядок и мировая политика","Kollage_001.png","#7ea4ba","#5aa4d3",1],
            ["Международная безопасность","Kollage_003.png","#b08a4f","#84bd32",3],
            ["Внешняя политика России","Kollage_004.png","#82b04f","#a29f9c",4],
            ["История международных отношений","Kollage_005.png","#d6d6d6","#7677c5",5],
            ["Международные организации","Kollage_002.png","#8477af","#e9ba50",2],
            ["Теория международных отношений","Kollage_006.png","#b0714f","#c77c49",6],
        ]);
    }

    private function addTopics($parentId, $data){
        foreach ($data as $item) {
            $outer = Topic::create([
                'title' => $item[0],
                'parent_topic_id' => $parentId,
                'img' => $item[1],
                'bgcolor' => $item[2],
                'menu_bgcolor' =>$item[3],
                'code'=> $item[4]
            ]);
        }
    }

    protected function importInnerPolitics(){
        $INNER_TOPIC_ID = (Topic::where('code',Topic::INNER_CODE)->first())->id;
        $path = "/Users/aleksejafanasev/Documents/Projects/Politics/Inner/";
        $file = "01_Внутренняя политика.xlsx";
        $dispatcher = new ImportDispatcher($path);
        $dispatcher->loadDataFromFile($file);
        $dispatcher->saveAsTxt('inner-politics-data.txt');
        $this->processItems($dispatcher->getIterator(),$INNER_TOPIC_ID, $path);
    }

    protected function importOuterPolitics(){
        $OUTER_TOPIC_ID = (Topic::where('code',Topic::OUTER_CODE)->first())->id;
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
                $item->storeToDB($rootTopicId,$path.'files');
                $this->log->info('['.$counter.'] Import success [title='.$item->name().']');
            } catch (\Exception $e) {
                $this->log->error('[' . $counter . '] Import failed [title=' . $item->name() . ']', ['error' => substr($e->getMessage(), 0, 500) . '...']);
            }

        }
    }

    public function importContent()
    {
        $basePath = '/Users/aleksejafanasev/Documents/Projects/Politics/final';
        $importer = new ContentImporter($basePath);

        $importer->checkData();
        $data = $importer->data();

//        $filters = $importer->getFilters();
//        $this->importMagazines();
//        $this->updateFilters($filters);
//        $this->createTopics();
//        dd('ok');

        $this->log = new Logger('import');
        $this->log->pushHandler(new StreamHandler($basePath.'/import.log', Logger::ERROR));

//        $OUTER_TOPIC_ID = (Topic::where('code',Topic::OUTER_CODE)->first())->id;
//        $this->importPart($data['outer'], $basePath.ContentImporter::OUTER_PATH,$OUTER_TOPIC_ID);

        $INNER_TOPIC_ID = (Topic::where('code',Topic::INNER_CODE)->first())->id;
        $this->importPart($data['inner'], $basePath.ContentImporter::INNER_PATH,$INNER_TOPIC_ID);
        dd('ok');


    }

    protected function importPart ($items, $path, $rootTopicID)
    {
        $this->processItems(new ImportObjectIterator($items),$rootTopicID, $path);
    }


    public function importOut()
    {
        $path = "/Users/aleksejafanasev/Documents/Projects/Politics";
        $this->log = new Logger('import');
        $this->log->pushHandler(new StreamHandler($path.'/import.log', Logger::ERROR));
        $this->importOuterPolitics();
    }


    public function importMagazines()
    {
        $importer = new MagazineImporter("/Users/aleksejafanasev/Documents/Projects/Politics/final/magazines","Список журналов.xlsx");
        $importer->do();
    }


    public function tt()
    {
        $data = $this->getTopics(null);
        return $data;
    }

    private function getTopics($id){
        return Topic::orderBy('parent_topic_id')->orderBy('id')->select(['id','title','menu_bgcolor as bgcolor','parent_topic_id as parent'])->get();


        $data = [];
        $topics = Topic::where('parent_topic_id',$id)->get();
        foreach ($topics as $topic){
            $td = new stdClass();
            $td->id = $topic->id;
            $td->title = $topic->title;
            $td->bgcolor = $topic->menu_bgcolor;
            if($topic->hasChildren()){
                $td->children = $this->getTopics($topic->id);
            }
            $data[] = $td;
        }
        return $data;
    }

    public function addArticlesToIndex()
    {
        $search = new Search();
        $articles = Article::all();
        foreach ($articles as $article){
            $search->addToIndex($article);
        }
    }

    public function createContentTypes(): void
    {
        ContentType::create(['code' => ContentType::ARTICLE, 'name' => 'Статьи']);
        ContentType::create(['code' => ContentType::BOOK, 'name' => 'Книги']);
        ContentType::create(['code' => ContentType::DOCUMENT, 'name' => 'Документы']);
    }


    public function updateContentFormat(){
        $articles = Article::all();
        foreach ($articles as $article){
            if($article->file !== null){
                $article->format = Article::PDF_TYPE;
                $article->save();
            }
        }
    }

    public function checkFiles(){
        $basePath = '/Users/aleksejafanasev/Documents/Projects/Politics/final';

        $importer = new ContentImporter($basePath);
        $importer->checkData();
    }


    public function updateTitleForSort()
    {
        $articles = Article::all();
        foreach ($articles as $article){
//            $article->title_for_sort = preg_replace("/^[\"'«]/","",mb_substr($article->title, 0, 10));
            $article->title_for_sort = str_replace(["\"","'","«"],"",mb_substr($article->title, 0, 10));
            $article->save();
        }
    }






}
