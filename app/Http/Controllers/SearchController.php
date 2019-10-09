<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @route /search
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {
        return ['page' => '/search','params' => $request->query()];
    }
}
