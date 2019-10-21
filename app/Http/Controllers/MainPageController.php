<?php

namespace App\Http\Controllers;

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
        return view('pages.main',compact('data','bgcolor','outerTopics','innerTopics'));
    }
}
