<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class Article extends Model
{

    const TEXT_TYPE = '1';
    const PDF_TYPE = '2';
    const LINK_TYPE = '3';

    protected $guarded = [];
    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    public function contentType()
    {
        return $this->belongsTo(ContentType::class);
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }

    public function organisations(){
        return $this->belongsToMany(Organisation::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function magazine()
    {
        return $this->belongsTo(Magazine::class);
    }

    public static function getFilteredList($filters = []){
        $query = DB::table('articles');

        foreach ($filters as $field=>$values){
            if(in_array($field,['author','region','organisation'])) {
                $query = self::attachRelationshipClause($field, $values, $query);
            } else {
                if(is_array($values)){
                    $query = $query->whereIn($field, $values);
                } else {
                    $query = $query->where($field, $values);
                }
            }
        }
        return $query->get();
    }

    protected static function attachRelationshipClause($table, $values, Builder $query){
        $tableName = 'article_'.$table;
        $fieldName = $tableName.'.'.$table.'_id';
        $newQuery = $query->join($tableName,'articles.id', '=', 'article_'.$table.'.article_id');
        if(is_array($values)){
            return $newQuery->whereIn($fieldName, $values);
        }

        return $newQuery->where($fieldName, $values);
    }

    public function attachFile($path, $title = ''){
        $file = File::add($path, $title);
        $this->file_id = $file->id;
        $this->save();
    }

    public function route(){
        if($this->format == self::LINK_TYPE ) return $this->externalUrl();
        return Route('articles',['article' => $this->id]);
    }

    protected function externalUrl(){
        if(strpos($this->link, 'https://') > -1) return $this->link;
        return 'http://' . str_replace('http://','',$this->link);
    }

    public function imgSrc()
    {
        return isset($this->img) ? config('app.url').'/storage/img/'.$this->img : config('app.url') .'/'.config('content.article-default-img');
    }

    public function letter()
    {
        preg_match('/^\W*?(\w)/mu',$this->title,$matches);
        return $matches[1];
    }

    public function breadcrumbs()
    {
        $breadcrumbs  = [];
        $path = $this->topic->path();
        foreach ($path as $topic){
            $breadcrumbs[] = ['link' => $topic['route'], 'title' => $topic['title']];
        }
        $breadcrumbs[] = ['link' => $this->route(), 'title' => $this->title];
        return $breadcrumbs;
    }

    public function formatCode()
    {
        $codes = [
            self::TEXT_TYPE => 'text',
            self::PDF_TYPE => 'pdf',
            self::LINK_TYPE => 'link',
        ];
        if(!in_array($this->format, array_keys($codes))) return $codes[self::TEXT_TYPE];

        return $codes[$this->format];
    }

    public function moreArticles()
    {
        return self::where('topic_id', $this->topic_id)
            ->where('id','<>',$this->id)
            ->orderBy('title')
            ->limit(config('content.more-article-count'))
            ->get();

    }

    public function openInNewTab()
    {
        return in_array($this->format,[self::LINK_TYPE, self::PDF_TYPE]);
    }
}
