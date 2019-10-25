<?php


namespace App\Import;


use App\Article;
use App\Author;
use App\ContentType;
use App\File;
use App\Helpers\WordReader;
use App\Magazine;
use App\Organisation;
use App\Region;
use App\Source;
use App\Topic;
use mysql_xdevapi\Exception;

class ImportItem
{
    private $data;
    const NUM_INDEX = 0;
    const TITLE_INDEX = 1;
    const FORMAT_INDEX = 2;
    const TOPIC3_INDEX = 3;
    const ANNOTATION_INDEX = 4;
    const AUTHOR_INDEX = 5;
    const SOURCE_INDEX = 6;
    const ORG_LINK_INDEX = 7;
    const ORG_INDEX = 8;
    const LINK_INDEX = 9;
    const YEAR_INDEX = 10;
    const REGION_INDEX = 11;
    const FILENAME_INDEX = 12;
    const COVER_FILENAME_INDEX = 13;
    const MAGAZINE_LINK_INDEX = 14;
    const IS_BOOK_INDEX = 15;
    const COMMENT_INDEX = 16;
    const TOPIC2_INDEX = 17;
    const TOPIC1_INDEX = 18;
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
        return $this->data[self::NUM_INDEX];
    }

    public function parent_topic()
    {
        return $this->data[self::TOPIC1_INDEX];
    }

    public function name()
    {
        return $this->data[self::TITLE_INDEX];
    }

    public function fileType()
    {
        return $this->data[self::FORMAT_INDEX];
    }

    public function contentType(){
        return $this->isBook() ? ContentType::BOOK : ContentType::ARTICLE;
    }


    public function topic()
    {
        return $this->data[self::TOPIC3_INDEX];
    }

    public function annotation()
    {
        return $this->data[self::ANNOTATION_INDEX] . '';
    }

    public function authors()
    {
        return $this->extractItemFromString($this->data[self::AUTHOR_INDEX]);
    }

    public function source()
    {
        return $this->data[self::SOURCE_INDEX];
    }

    public function link()
    {
        return $this->data[self::ORG_LINK_INDEX];
    }

    public function organizations()
    {
        return $this->extractItemFromString($this->data[8]);
    }

    public function articleLink()
    {
        return $this->data[self::LINK_INDEX];
    }

    public function year()
    {
        return $this->data[self::YEAR_INDEX];
    }

    public function regions()
    {
        return $this->extractItemFromString($this->data[self::REGION_INDEX]);
    }

    public function file()
    {
        return $this->data[self::FILENAME_INDEX];
    }

    public function cover()
    {
        return $this->data[self::COVER_FILENAME_INDEX];
    }

    public function magazineLink()
    {
        return $this->data[self::MAGAZINE_LINK_INDEX];
    }

    public function isBook()
    {
        return $this->data[self::IS_BOOK_INDEX];
    }

    public function comment()
    {
        return $this->data[self::COMMENT_INDEX];
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

        $magazineId = null;
        if($this->magazineLink() !== ''){
            $magazine = Magazine::where('slug', $this->magazineLink())->first();
            if(isset($magazine->id))  $magazineId = $magazine->id;
        }

        $source = Source::getOrCreate($this->source(), ['link'=>$this->link()]);
        $article = Article::create([
            'title' => $this->name(),
            'format' => (int)$this->fileType(),
            'annotation' => $this->annotation(),
            'source_id' => $source->id,
            'link' => $this->articleLink(),
            'year' => $this->year(),
            'img' => $this->cover(),
            'authors_string' => implode(', ', $this->authors()),
            'content_type_id' => ContentType::getId($this->contentType()),
            'magazine_id' => $magazineId,
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

    public function format(){
        $formats = [
            'pdf' => Article::PDF_TYPE,
            'doc' => Article::TEXT_TYPE,
            'link' => Article::LINK_TYPE
        ];
        if(!in_array($this->fileType(), array_keys($formats) )) throw  new \Exception('unrecognized item format: '. $this->fileType());
        return $formats[$this->fileType()];

    }
}
