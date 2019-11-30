<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;

class StaticContentController extends BaseController
{

    /**
     * @route /content
     * @return array
     */
    public function content()
    {
        $topics = Topic::getHierarchy();
        return view('pages.content',compact('topics'));
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


    /**
     * @route /partners/imi
     * @return array
     */
    public function imi()
    {
        return view('pages.partners.imi');
    }

    /**
     * @route /partners/rapn
     * @return array
     */
    public function rapn()
    {
        return view('pages.partners.rapn');
    }

    /**
     * @route /partners/cpimi
     * @return array
     */
    public function cpimi()
    {
        return view('pages.partners.cpimi');
    }
}
