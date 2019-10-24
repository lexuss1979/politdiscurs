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
        $contentType = self::where('code',$type)->get()->first();
        return $contentType ? $contentType->id : null;
    }

    public static function bookTypeID(){
       return self::getId(self::BOOK);
    }

    public static function articleTypeID(){
        return self::getId(self::ARTICLE);
    }

    public static function documentTypeID(){
        return self::getId(self::DOCUMENT);
    }

    public static function infographicsTypeID(){
        return self::getId(self::INFOGRAPHICS);
    }
}
