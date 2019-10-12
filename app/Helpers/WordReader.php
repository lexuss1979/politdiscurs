<?php


namespace App\Helpers;


use c;
use PhpOffice\PhpWord\Element\Image;
use PhpOffice\PhpWord\Element\ListItem;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\Element\TextBreak;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class WordReader
{
    private $reader;
    public function __construct($reader = null)
    {

        $this->reader = $reader ?? IOFactory::createReader('Word2007');;
    }

    public function read($filename)
    {
        $doc = $this->reader->load($filename);
        try{
            $html = $this->toHTML($doc);
        } catch (\Exception $e){
            throw new \Exception('Cannot parse to html file:'.$filename.' | Original:'.$e->getMessage());
        }
        return $html;
    }

    private function toHTML(PhpWord $doc){
        $body = '';
        $listBuffer = '';
        foreach($doc->getSections() as $section) {
            $arrays = $section->getElements();
            foreach($arrays as $e) {
                $paraStyle = 'p';
                $paraArray = [];
                if(get_class($e) === 'PhpOffice\PhpWord\Element\TextRun') {

                    foreach($e->getElements() as $text) {

                        if($text instanceof TextBreak){
                            $paraArray[] = ['', '<br/>'];
                            continue;
                        }
                        if($text instanceof Image){
                            continue;
                        }


                        $font = $text->getFontStyle();
                        if($font){
                            $size = $font->getSize()/10;

                            $classArray = [];

                            if($size == '1.8'){
                                $paraStyle = 'h1';
                            } else {
                                if($font->isBold()) $classArray[] = 'bold';
                                if($font->isItalic()) $classArray[] = 'italic';
                            }
                        }

                        $class = implode("-",$classArray);
                        $paraArray[] = [$class, $text->getText()];

                    }

                } else if(get_class($e) === 'PhpOffice\PhpWord\Element\ListItemRun'){
                    $paraStyle = 'li';
                    foreach($e->getElements() as $text) {
                        $paraArray[] = ['', $text->getText()];
                    }
                }
                $para = $this->generateHTMLfromArray($paraArray);
                if($paraStyle == 'li'){
                    $listBuffer .= $para!== '' ? '<'.$paraStyle.'>' . $para . '</' . $paraStyle . ">\n" : '';;
                } else {
                    if($listBuffer !== ''){
                        $body .= "<ul>\n".$listBuffer."</ul>\n";
                        $listBuffer ='';
                    }
                    $body .= $para!== '' ? '<'.$paraStyle.'>' . $para . '</' . $paraStyle . ">\n" : '';
                }



            }
        }
        return $body;
    }

    private function generateHTMLfromArray($paraArray){
        $resultArray = [];
        $currStyle = null;

        $buffer = '';
        foreach ($paraArray as $elem){
            if(empty($resultArray)) $currStyle = $elem[0];
            if($currStyle == $elem[0]){
                $buffer .= $elem[1];
            } else {
                $resultArray[] = [$currStyle, $buffer];
                $buffer = '';
                $currStyle = $elem[0];
            }
        }
        $resultArray[] = [$currStyle, $buffer];

        $html = '';
        foreach ($resultArray as $item){
            if($item[0] !== ''){
                $html .= '<span class="'. $item[0] .'">' .$item[1] . '</span>';
            } else {
                $html .= $item[1];
            }

        }
        return $html;
    }
}
