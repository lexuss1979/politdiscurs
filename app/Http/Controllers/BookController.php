<?php

namespace App\Http\Controllers;

use App\ArticleFilter;
use App\Book;
use App\ContentType;
use App\Topic;

class BookController extends BaseController
{


    /**
     * @route /books
     * @return array
     */
    public function index(Topic $topic = null)
    {
        $currPage = request('page') ?? 1;

        $request = request();
        $url = empty($request->query()) ?  $request->path() : $request->path().'?'.$request->getQueryString();

        $filter = new ArticleFilter();
        $query = $filter->ofTypes(ContentType::bookTypeID())
            ->orderByTitle()
            ->withPaging(config('content.articles-per-page'), $currPage)
            ->withLinks($url);

        if(isset($topic)){
            $query->forTopic($topic->id);
        }

        $data = $query->get()->asArray();
        $data['topics'] = json_encode(Topic::getAllTopicsList());
        return view('pages.books',compact('data', 'topic'));
    }


    /**
     * @route /books/{book}
     * @param Book $book
     * @return array
     */
    public function show(Book $book)
    {
        return ['page' => 'books/id','id' => $book];
    }
}
