<?php

namespace App\Http\Controllers;

use App\Article;
use App\Helpers\PaginatedCollection;
use App\Search;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
    /**
     * @route /search
     * @param Request $request
     * @param Search $search
     * @return array
     */
    public function search(Request $request, Search $search)
    {

        $query = request('q') ?? '';
        $currPage = request('page') > 0 ? (int)request('page') : 1;
        $baseUrl = route('search-results',['q' => $query]);

        $pageData = [
            'query' => $query,
            'results' => []
        ];
        if(!empty($query)){
            $collection =  $search->withPaging(config('content.search-results-per-page'),$currPage)
                ->withLinks($baseUrl)
                ->do($query);
            if( count(  $collection->content() ) > 0 ) {
                $pageData['results'] = $collection->content();
                $pageData['paging'] = $collection->paging();

            }
        }
        return view('pages.search-results',$pageData);
    }
}
