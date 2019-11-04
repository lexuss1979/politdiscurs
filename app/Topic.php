<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    public function getChildrenIdArray($recursive = false){
        if (!$recursive) return $this->children()->pluck('id')->toArray();
        $arrId = [$this->id];
        foreach ($this->children() as $child){
            $arrId = array_merge($arrId, $child->getChildrenIdArray(true));
        }
        return $arrId;


    }

    public function route()
    {
        if($this->isRoot()) return false;
        return  $this->hasChildren() ? route('topic',['topic' => $this->id]) : $this->parent()->route().'?topics[]='.$this->id ;
    }

    public function isRoot(){
        return is_null($this->parent_topic_id);
    }

    public function path()
    {
        return Cache::rememberForever('topic_path_'.$this->id, function () {
            if($this->isRoot()){
                return [[ 'route' => $this->route(), 'title' => $this->title]];
            } else {
                $parentPath = $this->parent()->path();
                return  array_merge($parentPath, [[ 'route' => $this->route(), 'title' => $this->title]]);
            }
        });


    }

    public static function getAllTopicsList(){
        return Cache::rememberForever('ALL_TOPICS_LIST', function () {
            return self::getList();
        });
    }

    protected static function getList($parentTopicId = null, $level = 1){
       $result = [];
       $topics = Topic::where('parent_topic_id',$parentTopicId)->get();
       foreach ($topics as $topic){
           $result[] = ['id' => $topic->id, 'title'=> $topic->title, 'level'=>$level, 'parent' => $topic->parent_topic_id];
           if($topic->hasChildren()){
               $childrenList = self::getList($topic->id, $level+1);
               $result = array_merge($result, $childrenList);
           }
       }
       return $result;
    }

    public static function getHierarchy()
    {
       return static::getChildrenTopics();

    }

    public static function getChildrenTopics($parentID = null, $level = 0){
        $children = static::where('parent_topic_id',$parentID)->get();
        foreach($children as $key=>$topic){
            $children[$key]->level = $level;
            $children[$key]->children = static::getChildrenTopics($topic->id,$level+1);
        }
        return $children;
    }
}
