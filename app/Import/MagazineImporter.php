<?php


namespace App\Import;


use App\Helpers\SpreadsheetReader;
use App\Helpers\WordReader;
use App\Magazine;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MagazineImporter
{

    protected $basePath;
    protected $indexFile;

    public function __construct($basePath, $indexFile)
    {
        $this->basePath = $basePath;
        $this->indexFile = $indexFile;
    }

    public function do()
    {
        $reader = new SpreadsheetReader($this->basePath .'/'.$this->indexFile,1,3);
        $data = $reader->processWorkSheetByName('Лист1');
        $log = new Logger('import-mag');
        $log->pushHandler(new StreamHandler($this->basePath.'/import.log', Logger::ERROR));
        $counter = 0;
        foreach ($data as $item){
            $counter++;
            try{
                $this->importItem($item);
            } catch (\Exception $e){
                $log->error('['.$counter.'] Import failed [title='.$item[0].']',['error'=>substr($e->getMessage(),0,500).'...'] );
            }

        }
    }

    protected function importItem($item){
        $data = [
            'name' => $item[0],
            'link' => $item[1],
            'slug' => $item[2],
            'img' => $this->copyImage($item[2]),
            'description' => $this->getDescription($item[2])
        ];
        return Magazine::create($data);

    }

    protected function copyImage($filename)
    {
        $imgPath = $this->basePath . '/Обложки/';
        $imgFile = $filename . '.jpg';
        if(file_exists($imgPath . $imgFile)){
            copy($imgPath . $imgFile, config('filesystems.disks.public.img').'/'.$imgFile);
            return $imgFile;
        }
        return '';
    }

    protected function getDescription($filename)
    {
        $reader = $reader ??  new WordReader();
        $docPath = $this->basePath . '/Аннотации/';
        $docFile = $filename . '.docx';
        $html = '';
        try {
            $html = $reader->read($docPath.$docFile);
        } catch (\Exception $e){
            throw new \Exception('error open file '. $docPath.$docFile . '. '. $e->getMessage());
        }
        return $html;
    }

}
