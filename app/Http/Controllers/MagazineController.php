<?php

namespace App\Http\Controllers;

use App\Helpers\PaginatedCollection;
use App\Magazine;
use Illuminate\Http\Request;

class MagazineController extends BaseController
{
    /**
     * @route /magazines
     * @return array
     */
    public function index()
    {
        $currPage = request('page') > 0 ? (int)request('page') : 1;
        $baseUrl = route('magazines');
        $magazines = new PaginatedCollection(Magazine::all(),config('content.magazines-per-page'), $currPage, $baseUrl);
        return view('pages.magazines-list',[
            'magazines' => $magazines->data(),
            'paging' => $magazines->paging()
        ]);
    }


    /**
     * @route /magazines/{magazine}
     * @param Magazine $magazine
     * @return array
     */
    public function show(Magazine $magazine)
    {
        $more = Magazine::where('id','<>',$magazine->id)->limit(config('content.magazines-in-more-block'));
        $more = $more->get();
        return view('pages.magazine-item',compact('magazine','more'));
    }
}

