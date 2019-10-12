<?php


namespace App\Import;

use GuzzleHttp\Client;
use ArrayIterator;
use GuzzleHttp\Exception\GuzzleException;
use PhpOffice\PhpSpreadsheet\IOFactory as IOFactoryAlias;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ImportDispatcher
{
    protected $basePath;
    protected $indexFile;
    protected $data = [];
    protected $reader = null;

    const START_ROW = 3;
    const COL_COUNT = 17;
    public function __construct($basePath)
    {
        $this->basePath = $basePath;

    }

    public function loadDataFromFile($filename){
        $this->indexFile = $filename;
        $spreadsheet = $this->getReader()->load($this->basePath . "/" . $this->indexFile);
        $this->processSpreadsheet($spreadsheet);

    }


    protected function processSpreadsheet(Spreadsheet $spreadsheet){
        $tabs = $spreadsheet->getSheetNames();
        foreach ($tabs as $tab){
            $this->data[$tab] = $this->processWorkSheet($spreadsheet->getSheetByName($tab));
        }

    }

    protected function processWorkSheet(Worksheet $worksheet){
        $wsData = [];
        $lines = $worksheet->getRowIterator();
        $rowCounter = 0;
        foreach ($lines as $line){
            $rowCounter++;
            if($rowCounter < self::START_ROW) continue;
            $lineData = $this->processRow($line);
            if( !$lineData ) break;

            $wsData[] = $lineData;
        }
        return $wsData;
    }

    protected function processRow(Row $line){
        $lineData = [];
        $cells = $line->getCellIterator();
        $counter = 0;
        foreach ($cells as $cell) {
            $counter++;
            $lineData[] = $cell->getValue();
            if($counter > self::COL_COUNT) break;
        }

        return $lineData[0] =='' ? false: $lineData;
    }

    protected function getReader()  {
        if(!$this->reader){
            try{
                $this->reader = IOFactoryAlias::createReader('Xlsx');
            } catch (\Exception $e){
                die('error:' . $e->getMessage());
            }

            $this->reader->setReadDataOnly(TRUE);
        }
        return $this->reader;
    }

    public function getData(){
        return $this->data;
    }

    public function saveAsTxt($file){
        $file = file_put_contents($this->basePath . "/". $file, serialize($this->data));
    }

    public function loadFromSerializedData($file){
        $data = file_get_contents($this->basePath . "/". $file);
        $this->data = \Opis\Closure\unserialize($data);
    }

    public function getIterator(){
        $flatData = [];
        foreach ($this->data as $key=>$topic){
            foreach ($this->data[$key] as $line) {
                $line[] = $key;
                $flatData[] = $line;
            }
        }
        return new ImportObjectIterator($flatData);
    }

    public function generateFilters(){
        $filters = [
            'types' => [],
            'sources' => [],
            'organizations' => [],
            'authors' => [],
            'regions' => [],
            'years' => [],
        ];
        $it = $this->getIterator();
        foreach ($it as $item){
            $this->addUnique($filters['types'], $item->fileType());
            $this->addUnique($filters['sources'], $item->source());
            $this->addUnique($filters['organizations'], $item->organizations());
            $this->addUnique($filters['authors'], $item->authors());
            $this->addUnique($filters['years'], $item->year());
            $this->addUnique($filters['regions'], $item->regions());
        }
        return $filters;
    }

    public function addUnique(&$array, $newData){
        if(is_array($newData)){
            foreach ($newData as $item){
                if(!in_array(trim($item), $array) && trim($item) !=='')  $array[] = trim($item);
            }
        } else {
            if(!in_array(trim($newData), $array) && trim($newData) !=='')  $array[] = trim($newData);
        }

    }

    public function saveFiltersAsTxt($file){
        $file = fopen($this->basePath ."/".$file,'w');
        $filters = $this->generateFilters();
        foreach ($filters as $filterName => $filterData){
            fwrite($file, $filterName . "\n-------------\n");
            $counter = 0;
            foreach ($filterData as $item){
                $counter++;
//                fwrite($file, $counter . ". " . $item ."\n");
                fwrite($file, $item ."\n");
            }
            fwrite($file, "\n\n");
        }
        fclose($file);
    }

    public function checkLinksAndFiles($filename = null){
        $errors = [
            "files" => $this->checkFiles(),
            "links" => []
        ];
        if($filename){
            setlocale(LC_ALL, 'ru_RU.UTF-8');
            $fp = fopen($this->basePath . '/'.$filename, 'w');

            foreach ($errors['files'] as $fields) {
                foreach ($fields as $k=>$f){
                    $fields[$k] = mb_convert_encoding($f, 'windows-1251', 'auto');
                }
                fputcsv($fp, $fields,';');
            }

            fclose($fp);
        }
        return $errors;
    }

    private function checkFiles(){
        $errors = [];
        $items = $this->getIterator();
        foreach ($items as $item) {
            if($item->hasFile() && $item->fileNotFoundInPath($this->basePath .'/files') ){
                $errors[] = [
                    'topic' => $item->parent_topic(),
                    'type' => $item->fileType(),
                    'number' => $item->number(),
                    'name' => $item->name(),
                    'file' => $item->getFullFileName()
                ];
            }
        }
        return $errors;
    }

    private function checkItemLink(ImportItem $item){
        if($item->article_link() !== ''){
            $client = new Client();
            try {
                var_dump('checking '. $item->article_link());
                $response = $client->request('GET', $item->article_link());
            } catch (GuzzleException $e) {
                return false;
            }
            return $response->getStatusCode() == 200;
        }
        return true;
    }

}
