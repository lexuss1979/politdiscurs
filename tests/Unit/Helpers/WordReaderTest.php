<?php

namespace Tests\Unit\Helpers;

use App\Helpers\WordReader;
use PHPUnit\Framework\TestCase;

class WordReaderTest extends TestCase
{

    public function testRead()
    {
        $file = ENV("FIXTURES_DIR").'/test.docx';
        $reader = new WordReader();
        $html = $reader->read($file);
        $this->assertStringContainsString('<h1>БЮРОКРАТИЯ (ЧИНОВНИЧЕСТВО) В РОССИИ</h1>',$html);
        $this->assertStringContainsString('<p>Бюрократия (или чиновничество) — категория лиц.</p>',$html);
        $this->assertStringContainsString('<p>Понятие «чиновничество» тесно связано с понятием «бюрократия.</p>',$html);
        $this->assertStringContainsString('<li>Теория и история социологии.</li>',$html);
        $this->assertStringContainsString('<li>Политическая культура и идеология.</li>',$html);
        $this->assertStringContainsString('О.В.Гаман-Голутвина',$html);
    }


}
