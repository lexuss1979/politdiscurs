<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    /**
     * @route /books
     * @return array
     */
    public function index()
    {
        return ['page' => 'books'];
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
