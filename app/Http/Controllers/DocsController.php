<?php


namespace App\Http\Controllers;


use App\ArticleFilter;
use App\Book;
use App\ContentType;
use App\Topic;

class DocsController extends BaseController
{
    /**
     * @route /books
     * @return array
     */
    public function index()
    {
        $currPage = request('page') ?? 1;

        $request = request();
        $url = empty($request->query()) ?  $request->path() : $request->path().'?'.$request->getQueryString();

        $filter = new ArticleFilter();
        $query = $filter->ofTypes(ContentType::documentTypeID())
            ->orderByTitle()
            ->withPaging(config('content.articles-per-page'), $currPage)
            ->withLinks($url)
            ->orderByTitle();

        $data = $query->get()->asArray();

        return view('pages.docs',compact('data'));
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
