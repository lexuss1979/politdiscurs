<?php

namespace App;

use App\Helpers\PaginatedCollection;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $table = 'search';
    protected $fillable = ['text','article_id'];

    protected $perPage = null;
    protected $currentPage = 1;

    const DELIMITER = ' | ';
    public function addToIndex(Article $article)
    {
        self::where('article_id',$article->id)->delete();
        $searchBase = implode(self::DELIMITER, [$article->title, $article->annotation, $article->year, $article->authors_string]);
        return self::create(['text' => $searchBase, 'article_id' => $article->id]);
    }

    public function withPaging($perPage, $currentPage = 1){
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        return $this;
    }

    public function do($searhStr)
    {
        $results = Search::whereRaw('text like ?', ["%{$searhStr}%"])
            ->join('articles','articles.id','=','search.article_id')
            ->select('articles.*')
            ->get();
        $data = new PaginatedCollection($results,$this->perPage, $this->currentPage);
        return new ContentCollection($data,[]);
    }
}
