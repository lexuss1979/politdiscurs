<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{

    protected $fillable = ['title','parent_topic_id','img','bgcolor'];
    protected $guarded = [];

    public static function getOrCreate($topicName, $parentTopic){
        $parenTopicID = self::getTopicId($parentTopic);
        $topic = self::where('title',$topicName)->where('parent_topic_id',$parenTopicID)->find(1);
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
            $test = self::where('title',$topic);
            return !is_null($test) ? $test->id : null;
        }


    }

    public function parent(){
        return is_null($this->parent_topic_id) ? null : Topic::find($this->parent_topic_id);
    }
}
