<?php

namespace App\Http\Controllers;

use App\ArticleFilter;
use App\Author;
use App\Helpers\VueFilterDataGenerator;
use App\Organisation;
use App\Region;
use App\Topic;
use Illuminate\Http\Request;

class TopicController extends BaseController
{


    /**
     * @route /topics/{topic}
     * @param Topic $topic
     * @return array
     */
    public function show(Topic $topic)
    {

        $filter = new ArticleFilter();
        $currPage = request('page') ?? 1;

        $request = request();
        $url = empty($request->query()) ?  $request->path() : $request->path().'?'.$request->getQueryString();


        $query = $filter->forTopic($topic->id)
            ->withPaging(config('content.articles-per-page'), $currPage)
            ->withLinks($url);
        if(request('sort') !== null){
            switch (request('sort') ){
                case 2:
                    $query->orderByAuthor();
                    break;

                case 3:
                    $query->orderByYear();
                    break;

                case 1:
                    $query->orderByTitle();
                    break;

            }
        }
        if(request('author') !== null){
            $query->forAuthor(Author::find((int)request('author')));
        }
        if(request('reg') !== null){
            $query->forRegion(Region::find((int)request('reg')));
        }

        if(request('org') !== null){
            $query->forOrganisation(Organisation::find((int)request('org')));
        }

        if(request('topics') !== null){
            $topics = array_map(function($item){return (int)$item;},request()->input('topics'));
            $query->forTopic($topics);
        }

         $data = $query->get()->asArray();
         $vueDataGenerator = new VueFilterDataGenerator(request(), $data['filters']);
         $data['filters'] = $vueDataGenerator->getJSON();



        return view('pages.topics',compact('data', 'topic'));
    }


}
