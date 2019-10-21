<?php


namespace App\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    public function __construct()
    {
        $defaults = [
            'h1' => config('content.default_H1'),
            'h2' => config('content.default_H2')
        ];
        View::share('defaults', $defaults);
    }
}
