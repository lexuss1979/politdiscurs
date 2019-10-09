<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

abstract class FilterModel extends Model
{


    public static function refreshFilterData($data){
        static::query()->delete();
        foreach ($data as $item){
            static::getOrCreate($item);
        }
    }
    public static function getOrCreate($value){
        $obj = static::where(static::keyField(),$value)->find(1);
        if($obj) return $obj;

        $obj = static::create([
            static::keyField() => $value
        ]);
        return $obj;
    }
    abstract protected static function keyField();
}
