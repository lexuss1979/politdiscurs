<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['path','title','filename'];

    public static function add($pathToFile, $title = ""){
        $destPath = config('filesystems.disks.public.files');
        $filename = pathinfo($pathToFile,PATHINFO_BASENAME);

        copy($pathToFile,$destPath.'/'.$filename);
        $file = File::create([
            'path' => $destPath,
            'filename' => $filename,
            'title' => $title
        ]);
        return $file;
    }

    public function getUrl(){

    }

    public function delete(){
        unlink ($this->getFullPath());
        Parent::delete();
    }

    private function getFullPath(){
        return $this->path .'/'.$this->filename;
    }

}
