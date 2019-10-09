<?php

namespace App\Http\Controllers;

use App\Magazine;
use Illuminate\Http\Request;

class MagazineController extends Controller
{
    /**
     * @route /magazines
     * @return array
     */
    public function index()
    {
        return ['page' => 'magazines'];
    }


    /**
     * @route /magazines/{magazine}
     * @param Magazine $magazine
     * @return array
     */
    public function show(Magazine $magazine)
    {
        return ['page' => 'magazines/{magazine}','id' => $magazine];
    }
}

