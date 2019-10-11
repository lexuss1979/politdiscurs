<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentType extends FilterModel
{

    const ARTICLE = 'article';
    const DOCUMENT  = 'document';
    const BOOK = 'book';
    const INFOGRAPHICS = 'infographics';
    protected $fillable = ['name','code'];

    protected static function keyField()
    {
        return 'code';
    }

    public static function getId($type){
        $type = self::where('code',$type)->get()->first();
        return $type ? $type->id : null;
    }
}
