<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    public function contentType()
    {
        return $this->belongsTo(ContentType::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public static function getFilteredList($filters = []){
        $query = DB::table('articles');

        foreach ($filters as $field=>$values){
            if(is_array($values)){
                $query = $query->whereIn($field, $values);
            } else {
                $query = $query->where($field, $values);
            }
        }
        return $query->get();
    }
}
