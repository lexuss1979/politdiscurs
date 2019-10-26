<?php

namespace App;



class Book extends Article
{
    public static function getListForMainPage()
    {
        return Article::books()->where('main_page',true)->limit(config('content.books-on-main-page',10))->get();
    }

    public static function count()
    {
        return Article::books()->count();
    }
}
