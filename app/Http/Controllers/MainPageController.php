<?php

namespace App\Http\Controllers;

use App\Book;
use App\Magazine;
use App\Topic;
use Illuminate\Http\Request;

class MainPageController extends BaseController
{
    public function index()
    {

        $data = [
            'page' => 'main-page',

        ];
        $bgcolor = 'ddffdd';
        $outerTopics = Topic::outerPolitics()->get();
        $innerTopics = Topic::innerPolitics()->get();
        $magazines = Magazine::getListForMainPage();
        $magazinesCount = Magazine::count();
        $books = Book::getListForMainPage();
        $booksCount = Book::count();
        return view('pages.main',compact('data',
            'bgcolor',
            'outerTopics',
            'innerTopics',
            'magazines',
            'magazinesCount',
            'books',
            'booksCount'
        ));
    }
}
