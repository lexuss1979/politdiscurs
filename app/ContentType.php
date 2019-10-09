<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentType extends FilterModel
{
    protected $fillable = ['name','code'];

    protected static function keyField()
    {
        return 'name';
    }
}
