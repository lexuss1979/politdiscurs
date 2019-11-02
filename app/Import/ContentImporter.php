<?php


namespace App\Import;


use App\Helpers\SpreadsheetReader;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class ContentImporter
{
    const MAGAZINE_PATH = '/magazines/';
    const INNER_PATH = '/inner/';
    const OUTER_PATH = '/outer/';


    protected $basePath;
    protected $magazinesData;
    protected $magazinesCodes;
    protected $innerData;
    protected $outerData;

    protected $errors;
    protected $filters;




    public function __construct($path)
    {
        $this->basePath = $path;
        $this->filters = [
            'authors' => [],
            'regions' => [],
            'sources' => [],
            'years' => [],
            'orgs' => [],
        ];

        $this->errors = [
            self::INNER_PATH => [],
            self::OUTER_PATH => []
        ];
    }

    public function getFilters(){
        return $this->filters;
    }

    public function data(){
        return [
            'inner' => $this->preparedForImport($this->innerData,'Внутренняя политика'),
            'outer' => $this->preparedForImport($this->outerData,'Международные отношения'),
            'magazines' => $this->magazinesData
        ];
    }

    protected function preparedForImport($rawData, $rootTopicName){
        $result = [];
        foreach ($rawData as $item){
            $result[] = $this->getImportItem($item, $rootTopicName);
        }
        return $result;
    }


    public function checkData()
    {
        $this->readData();
        foreach ($this->innerData as $innerItem){
            $this->checkItem($innerItem,self::INNER_PATH);
            $this->extractFilters($innerItem);
        }
        foreach ($this->outerData as $outerItem){
            $this->checkItem($outerItem,self::OUTER_PATH);
            $this->extractFilters($outerItem);
        }
//        $this->saveToFile();
//        dd(['errors' => $this->errors, 'filters' => $this->filters]);
    }

    protected function saveToFile()
    {
        file_put_contents($this->basePath.'/logs/errors-inner.txt', implode("\n",$this->errors[self::INNER_PATH]));
        file_put_contents($this->basePath.'/logs/errors-outer.txt', implode("\n",$this->errors[self::OUTER_PATH]));

        foreach ($this->filters as $filter => $data){
            $this->saveFilterToFile($filter);
        }

    }

    protected function saveFilterToFile($filterName){
        asort($this->filters[$filterName]);
        file_put_contents($this->basePath."/logs/{$filterName}-filter.txt", implode("\n",$this->filters[$filterName]));
    }

    protected function readData(){
        $this->magazinesData = $this->getData($this->basePath . self::MAGAZINE_PATH . 'Список журналов.xlsx',1,3);
        $this->innerData  = $this->getData($this->basePath . self::INNER_PATH . '01_Внутренняя политика_V2.xlsx',3,20);
        $this->outerData  = $this->getData($this->basePath . self::OUTER_PATH . '02_Международная политика_V2.xlsx',3,20);
    }

    protected function getData($path, $startFromRow, $colCount){
        $serializedDataFile = $path.'.sr.txt';
        if(file_exists($serializedDataFile)){
            $data = unserialize(file_get_contents($path.'.sr.txt'));
        } else {
            try {
                $excel = new SpreadsheetReader($path, $startFromRow, $colCount);
            } catch (Exception $e) {
                dd($e->getMessage());
            }
            $data =  $excel->processWorkSheetByName('Лист1');
            unset($excel);
            file_put_contents($serializedDataFile,serialize($data));
        }
        return $data;
    }


    protected function extractFilters($item){
        $this->extractAuthors($item);
        $this->extractOrgs($item);
        $this->extractRegions($item);
        $this->extractSources($item);
        $this->extractYear($item);

    }

    protected function extractAuthors($item)
    {
        $this->extractedFiltersFromString($this->filters['authors'], $item[8]);
    }
    protected function extractOrgs($item)
    {
        $this->extractedFiltersFromString($this->filters['orgs'], $item[11]);
    }
    protected function extractSources($item)
    {
        $filterItems = explode(',',$item[9]);
        foreach ($filterItems as $filterItem){
            if($filterItem !== '') {
                $filterItem = trim($filterItem);
                $filterExists = false;
                foreach ($this->filters['sources'] as $org){
                    if($org['name'] == $filterItem) {
                        $filterExists = true;
                        break;
                    }
                }
                if(!$filterExists) $this->filters['sources'][] = ['name' => $filterItem, 'link' => $item[10]];
            }
        }
    }

    protected function extractYear($item)
    {
        $this->extractedFiltersFromString($this->filters['years'], $item[13]);
    }

    protected function extractRegions($item)
    {
        $this->extractedFiltersFromString($this->filters['regions'], $item[14]);
    }


    protected function extractedFiltersFromString(&$filtersArr, $string){
        $filterItems = explode(',',$string);
        foreach ($filterItems as $filterItem){
            $filterItem = trim($filterItem);
            if( $filterItem !== '' && !in_array($filterItem, $filtersArr)) $filtersArr[] = $filterItem;
        }
    }

    protected function checkItem($item, $path)
    {
        $this->checkAnnotation($item, $path);
        $this->checkCoverFile($item, $path);
        $this->checkLink($item, $path);
        $this->checkMagazineLink($item, $path);
        $this->checkSourceFile($item, $path);
    }

    protected function checkAnnotation($item, $path)
    {
        $annotationFileName =  $path .'files/'.$item[15].'.docx';
        if($item[4] == 'doc' || $item[3] == 'doc' ) {
            if($item[15] == '') {
                $this->error("[{$item[0]}] - Отсутствует имя файла описания", $path);
            } else if( !file_exists($this->basePath . $annotationFileName)){
                $this->error("[{$item[0]}] - Файл описания не найден ".$annotationFileName, $path);
            }

        } else if( $item[3] == 'link'  && $item[15] != '' && !file_exists($this->basePath . $annotationFileName)){
            $this->error("[{$item[0]}] - Файл описания не найден ".$annotationFileName, $path);
        }
    }

    protected function checkLink($item, $path)
    {
        if($item[3] == 'link' && $item[12] == "") {
                $this->error("[{$item[0]}] - Отсутствует ссылка на статью", $path);

        }
    }

    protected function checkSourceFile($item, $path)
    {
        if($item[3] == 'pdf') {
            $contentFileName = $path .'files/'.$item[15].'.pdf';
            if($item[15] == '') {
                $this->error("[{$item[0]}] - Отсутствует имя файла содержания", $path);
            } else if( !file_exists( $this->basePath . $contentFileName)){
                $this->error("[{$item[0]}] - Файл содержания не найден ".$contentFileName, $path);
            }

        }
    }

    protected function getImportItem($data, $rootTopicName){
        return [
            ImportItem::NUM_INDEX => $data[0],
            ImportItem::TITLE_INDEX => $data[2],
            ImportItem::FORMAT_INDEX => $data[3],
            ImportItem::TOPIC3_INDEX => $data[6],
            ImportItem::ANNOTATION_INDEX => $data[7],
            ImportItem::AUTHOR_INDEX => $data[8],
            ImportItem::SOURCE_INDEX => $data[9],
            ImportItem::ORG_LINK_INDEX => $data[10],
            ImportItem::ORG_INDEX => $data[11],
            ImportItem::LINK_INDEX => $data[12],

            ImportItem::YEAR_INDEX => $data[13],
            ImportItem::REGION_INDEX => $data[14],
            ImportItem::FILENAME_INDEX => $data[15],
            ImportItem::COVER_FILENAME_INDEX => $data[16],

            ImportItem::MAGAZINE_LINK_INDEX => $data[17],
            ImportItem::IS_BOOK_INDEX => $data[18],
            ImportItem::IS_DOCUMENT_INDEX => $data[19],


            ImportItem::TOPIC1_INDEX => $rootTopicName,
            ImportItem::TOPIC2_INDEX => $data[5],
        ];
    }


    protected function importAllData(){

    }


    protected function checkCoverFile($item, $path)
    {
        if($item[16] != '') {
            $coverFileNameJPG =  $path .'files/'.$item[16].'.jpg';
             if( !file_exists($this->basePath . $coverFileNameJPG)){
                $this->error("[{$item[0]}] - Изображение обложки не найдено ".$coverFileNameJPG, $path);
            }

        }
    }

    protected function checkMagazineLink($item, $path)
    {
        if($item[17] != false && !$this->validMagazineCode($item[17])) {
            $this->error("[{$item[0]}] - Некорректный код журнала ". $item[17], $path);
        }
    }

    protected function error($msg, $path)
    {
        $this->errors[$path][] = $msg;
    }


    protected function validMagazineCode($code){
        if(empty($this->magazinesCodes) ) $this->magazinesCodes = array_column($this->magazinesData,2);

        return in_array($code, $this->magazinesCodes);
    }

}
