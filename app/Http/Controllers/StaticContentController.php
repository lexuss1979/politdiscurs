<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticContentController extends Controller
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
        return ['page' => '/about'];
    }

    /**
     * @route /authors
     * @return array
     */
    public function authors()
    {
        return ['page' => '/authors'];
    }

    /**
     * @route /partners
     * @return array
     */
    public function partners()
    {
        return ['page' => '/partners'];
    }
}
