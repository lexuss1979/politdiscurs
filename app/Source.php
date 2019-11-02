<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends FilterModel
{

    protected $fillable = ['name','link'];

    public static function refreshFilterData($data){
        static::query()->delete();
        foreach ($data as $item){
            static::getOrCreate($item['name'], ['link' => $item['link']]);
        }
    }

    protected static function keyField()
    {
        return 'name';
    }


}
