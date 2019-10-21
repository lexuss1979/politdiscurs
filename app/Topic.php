<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{

    protected $fillable = ['title','parent_topic_id','img','bgcolor','menu_bgcolor','code'];
    protected $guarded = [];

    const INNER_CODE = 100;
    const OUTER_CODE = 200;

    public function scopeInnerPolitics($query)
    {
        $root = self::where('code',self::INNER_CODE)->first();
        return $query->where('parent_topic_id', $root->id);
    }

    public function scopeOuterPolitics($query)
    {
        $root = self::where('code',self::OUTER_CODE)->first();
        return $query->where('parent_topic_id', $root->id);
    }

    public static function getOrCreate($topicName, $parentTopic){
        $parenTopicID = self::getTopicId($parentTopic);
        $topic = self::where('title',$topicName)
            ->where('parent_topic_id',$parenTopicID)
            ->get()->first();
        if($topic) return $topic;

        $topic = self::create([
            'title' => $topicName,
            'parent_topic_id' => $parenTopicID
        ]);
        return $topic;
    }

    protected static function getTopicId($topic){
        if($topic instanceof self) return $topic->id;
        if(is_numeric($topic)) return $topic;

        //$topic is string
        if(is_string($topic) && $topic != ''){
            $test = self::where('title',$topic)->get()->first();
            return !is_null($test) ? $test->id : null;
        }


    }

    public function parent(){
        return is_null($this->parent_topic_id) ? null : Topic::find($this->parent_topic_id);
    }
    public function children(){
        return Topic::where('parent_topic_id',$this->id)->get();
    }

    public function hasChildren(){
        return Topic::where('parent_topic_id',$this->id)->exists();
    }

    public function getChildrenIdArray(){
        return $this->children()->pluck('id')->toArray();
    }
}
