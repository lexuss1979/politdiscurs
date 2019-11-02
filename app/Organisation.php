<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation extends FilterModel
{
    protected $fillable = ['name'];



    protected static function keyField()
    {
        return 'name';
    }
}
