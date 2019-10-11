<?php


namespace App\Import;


use App\Article;
use App\Author;
use App\ContentType;
use App\File;
use App\Helpers\WordReader;
use App\Organisation;
use App\Region;
use App\Source;
use App\Topic;
use mysql_xdevapi\Exception;

class ImportItem
{
    private $data;
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


    public function __construct($data)
    {
        $this->data = $data;
    }

    public function number()
    {
        return $this->data[0];
    }

    public function parent_topic()
    {
        return $this->data[18];
    }

    public function name()
    {
        return $this->data[1];
    }

    public function fileType()
    {
        return $this->data[2];
    }

    public function contentType(){
        return $this->isBook() ? ContentType::BOOK : ContentType::ARTICLE;
    }


    public function topic()
    {
        return $this->data[3];
    }

    public function annotation()
    {
        return $this->data[4] . '';
    }

    public function authors()
    {
        return $this->extractItemFromString($this->data[5]);
    }

    public function source()
    {
        return $this->data[6];
    }

    public function link()
    {
        return $this->data[7];
    }

    public function organizations()
    {
        return $this->extractItemFromString($this->data[8]);
    }

    public function article_link()
    {
        return $this->data[9];
    }

    public function year()
    {
        return $this->data[10];
    }

    public function regions()
    {
        return $this->extractItemFromString($this->data[11]);
    }

    public function file()
    {
        return $this->data[12];
    }

    public function cover()
    {
        return $this->data[13];
    }

    public function isMagazine()
    {
        return $this->data[14];
    }

    public function isBook()
    {
        return $this->data[15];
    }

    public function comment()
    {
        return $this->data[16];
    }

    public function getFullFileName(){
        $filename = $this->file();
        if(strpos('.',$filename) <1){
            $filename = $filename . '.' . $this->fileExtension();
        }
        return $this->parent_topic() .'/'.$filename;
    }


    public function fileNotFoundInPath($path){
        $fullFilePath = $path . '/'. $this->getFullFileName();
        $fileFound = file_exists($fullFilePath);
        if(!$fileFound && $this->fileExtension() == 'doc'){
            //try to find .docx file
            $fileFound = file_exists($fullFilePath .'x');
        }
        return  !$fileFound;
    }

    public function hasFile(){
        return $this->file() != '';
    }
    protected function fileExtension(){
        return $this->fileType() == 'doc' ? 'docx': $this->fileType();
    }

    public function storeToDB($rootTopicId, $contentPath, WordReader $reader = null){

        $parentTopic = Topic::getOrCreate($this->parent_topic(), $rootTopicId);
        $articleTopic = Topic::getOrCreate($this->topic(), $parentTopic->id);
        $html = '';
        $fileID = null;
        $fullFilePath = $contentPath . '/'. $this->getFullFileName();
        if($this->fileType() == 'doc'){
            $reader = $reader ??  new WordReader();
            try {
                $html = $reader->read($fullFilePath);
            } catch (\Exception $e){
                throw new \Exception('error open file '. $fullFilePath . '. '. $e->getMessage());
            }

        } elseif ($this->fileType() == 'pdf'){
            $fileID = (File::add($fullFilePath))->id;
        }
        $source = Source::getOrCreate($this->source());
        $article = Article::create([
            'title' => $this->name(),
            'format' => (int)$this->fileType(),
            'annotation' => $this->annotation(),
            'source_id' => $source->id,
            'link' => $this->link(),
            'year' => $this->year(),
            'img' => $this->cover(),
            'authors_string' => implode(', ', $this->authors()),
            'content_type_id' => ContentType::getId($this->contentType()),
            'topic_id' => $articleTopic->id,
            'file_id' => $fileID,
            'html' => $html
            ]);


        foreach ($this->authors() as $authorName){
            $author = Author::getOrCreate($authorName);
            $article->authors()->attach($author);
        }

        foreach ($this->organizations() as $orgName){
            $org = Organisation::getOrCreate($orgName);
            $article->organisations()->attach($org);
        }

        foreach ($this->regions() as $regName){
            $region = Region::getOrCreate($regName);
            $article->regions()->attach($region);
        }



        return $article;
        //parent topic
        //root topic
        //filters id
        //create model
        //add fields
        //store
    }

    protected function extractItemFromString($str){
        $arr = explode(',',$str);
        foreach ($arr as $key=>$val){
            $arr[$key] = trim($val);
        }
        return $arr;
    }
}
