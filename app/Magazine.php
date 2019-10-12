<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    protected $fillable = ['name','description','img','slug','link'];
}
