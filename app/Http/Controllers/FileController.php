<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Start download the file
     *
     * @route /files/{file}
     * @param File $file
     * @return array
     */
    public function show(File $file)
    {
        return ['page' => 'files/{file}','id' => $file->id];
    }
}
