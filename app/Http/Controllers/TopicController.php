<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{


    /**
     * @route /topics/{topic}
     * @param Topic $topic
     * @return array
     */
    public function show(Topic $topic)
    {
        return ['page' => 'topics/{topic}','id' => $topic->id];
    }


}
