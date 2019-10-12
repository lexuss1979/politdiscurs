<?php


namespace App\Helpers;


use PhpOffice\PhpSpreadsheet\IOFactory as IOFactoryAlias;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SpreadsheetReader
{
    protected $colCount;
    protected $startFromRow;
    protected $fileName;
    protected $reader;
    protected $spreadsheet;

    /**
     * SpreadsheetReader constructor.
     * @param $fileName
     * @param $startFromRow
     * @param $colCount
     * @throws Exception
     */
    public function __construct($fileName, $startFromRow, $colCount)
    {
        $this->startFromRow = $startFromRow;
        $this->colCount = $colCount;
        $this->fileName = $fileName;
        $this->spreadsheet = $this->getReader()->load($fileName);
    }

    public function processSpreadsheet($spreadsheet){
        $tabs = $spreadsheet->getSheetNames();
        foreach ($tabs as $tab){
            $this->data[$tab] = $this->processWorkSheet($spreadsheet->getSheetByName($tab));
        }

    }

    public function getWorksheet($name){
        return $this->spreadsheet->getSheetByName($name);
    }

    public function processWorkSheetByName($worksheetName){
        return $this->processWorkSheet($this->getWorksheet($worksheetName));
    }

    public function processWorkSheet(Worksheet $worksheet){
        $wsData = [];
        $lines = $worksheet->getRowIterator();
        $rowCounter = 0;
        foreach ($lines as $line){
            $rowCounter++;
            if($rowCounter < $this->startFromRow) continue;
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
            if($counter > $this->colCount) break;
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
}
