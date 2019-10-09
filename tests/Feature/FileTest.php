<?php

namespace Tests\Feature;

use App\File;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileTest extends TestCase
{

    use RefreshDatabase;
    /** @test */
    public function it_can_create_file()
    {
        $fileName = 'example.txt';
        $fileTitle = 'My title';
        $destFile = config('filesystems.disks.public.files').'/'.$fileName;
        $this->assertFileNotExists($destFile);
        $file = $this->createFile($fileName,$fileTitle);
        $this->assertFileExists($destFile);
        $this->assertInstanceOf(File::class, $file);
        $this->assertEquals($fileTitle, $file->title);
        $this->assertEquals(config('filesystems.disks.public.files'), $file->path);
        $this->assertEquals($fileName, $file->filename);


        unlink($destFile);

    }

    /** @test */
    public function it_can_delete_files()
    {
        $fileName = 'example.txt';
        $fileTitle = 'My title';
        $destFile = config('filesystems.disks.public.files').'/'.$fileName;
        $file = $this->createFile($fileName,$fileTitle);
        $file->delete();
        $this->assertFileNotExists($destFile);

    }

    private function createFile($filename, $title){
        $sourceFile = ENV('FIXTURES_DIR').'/'.$filename;
        file_put_contents($sourceFile,'test');
        $file =  File::add($sourceFile, $title);

        unlink($sourceFile);

        return $file;
    }
}
