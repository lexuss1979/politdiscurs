<?php

namespace App\Http\Controllers;

use App\Article;
use App\Helpers\PaginatedCollection;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
    /**
     * @route /search
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {

        $query = request('q') ?? '';
        $currPage = request('page') > 0 ? (int)request('page') : 1;
        $baseUrl = route('search-results',['q' => $query]);

        $pageData = [
            'query' => $query,
            'results' => []
        ];
        if(!empty($query)){
            $collection = new PaginatedCollection(Article::where('title','like','%'.$query.'%')->orWhere('annotation','like','%'.$query.'%')->get()
                ,config('content.search-results-per-page')
                ,$currPage, $baseUrl);

            if( count(  $collection->data() ) > 0 ) {
                $pageData['results'] = $collection->data();
                $pageData['paging'] = $collection->paging();
            }
        }
        return view('pages.search-results',$pageData);
    }
}
