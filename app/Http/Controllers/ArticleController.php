<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

class ArticleController extends BaseController
{

    /**
     * Display the article
     *
     * @route /articles/{article}
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        if(isset($article->file->id)){
            $fileContents = File::get(storage_path('app/public/files/') .  $article->file->filename );

            return Response::make($fileContents, 200, array('Content-Type' => 'application/pdf'));
        }

        return view('pages.article',compact('article'));
    }


}
