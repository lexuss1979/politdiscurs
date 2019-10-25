<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    protected $fillable = ['name','description','img','slug','link'];

    public function articles()
    {
        return $this->hasMany(Article::class)->orderBy('title');
    }

    public function route(){
        return Route('magazine-item',['magazine' => $this->id]);
    }

    public function imgSrc()
    {
        return isset($this->img) ? config('app.url').'/storage/img/'.$this->img : config('app.url') .'/'.config('content.article-default-img');
    }
}
