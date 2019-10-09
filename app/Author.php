<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends FilterModel
{
    //
   protected $fillable = ['fio','annotation'];

    protected static function keyField()
    {
        return 'fio';
    }
}
