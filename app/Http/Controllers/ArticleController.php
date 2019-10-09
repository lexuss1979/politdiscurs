<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    /**
     * Display the article
     *
     * @route /articles/{article}
     * @param Article $article
     * @return array
     */
    public function show(Article $article)
    {
        return ['page' => 'articles/{article}','id' => $article->id];
    }


}
