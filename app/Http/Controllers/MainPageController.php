<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainPageController extends Controller
{
    public function index()
    {
        $data = [
            'page' => 'main-page',
        ];
        $bgcolor = 'ddffdd';
        return view('pages.main',compact('data','bgcolor'));
    }
}
