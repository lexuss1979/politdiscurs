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
    public static function getOrCreate($value, $params = []){
        $obj = static::where(static::keyField(),$value)->get()->first();
        if($obj) return $obj;

        $data = [ static::keyField() => $value ];
        foreach ($params as $key => $val){
            $data[$key] = $val;
        }

        $obj = static::create($data);
        return $obj;
    }
    abstract protected static function keyField();
}
