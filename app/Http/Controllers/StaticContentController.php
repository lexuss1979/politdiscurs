<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticContentController extends BaseController
{

    /**
     * @route /content
     * @return array
     */
    public function content()
    {
        return ['page' => '/content'];
    }

    /**
     * @route /about
     * @return array
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * @route /authors
     * @return array
     */
    public function contributors()
    {
        return view('pages.contributors');
    }

    /**
     * @route /partners
     * @return array
     */
    public function partners()
    {
        return view('pages.partners');
    }
}
