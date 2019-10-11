<?php


namespace App;


use App\Helpers\PaginatedCollection;
use Illuminate\Database\Eloquent\Collection;

class ArticleFilter
{
    private $content;
    private $filters;
    private $pagination;

    private $topic;
    private $year;
    private $author;
    private $region;
    private $contentTypes = [];

    private $sortField = 'id';
    private $sortDirection = 'asc';

    private $query;


    private $itemsPerPage;
    private $currentPage = 1;



    public function __construct()
    {
    }

    public function get(){
        $this->applyFilters();
        $this->applySorting();
        $this->execute();

        return new ContentCollection($this->content(), $this->getFiltersSets());
    }

    protected function content(): PaginatedCollection{
        return new PaginatedCollection($this->content, $this->itemsPerPage, $this->currentPage);
    }

    protected function applyFilters(){
        $this->query = Article::whereRaw("1 = 1");
        $this->attachTopicFilter()
            ->attachYearFilter()
            ->attachAuthorFilter()
            ->attachRegionFilter()
            ->attachContentTypeFilter();
        return $this->query;
    }

    private function applySorting()
    {
        return $this->query->orderBy($this->sortField, $this->sortDirection);
    }

    protected function getFiltersSets(){

        return [
            'authors' => $this->getAuthorsSet(),
            'regions' => $this->getRegionsSet(),
            'years' => $this->getYearsSet(),
        ];
    }

    protected function getAuthorsSet(){
        $authors = Author::join('article_author','authors.id','=','article_author.author_id')
            ->whereIn('article_author.article_id',$this->getContentIds())
            ->select(['authors.id','authors.fio'])
            ->distinct()
            ->orderBy('authors.fio')
            ->get()->toArray();
        return $authors ?? [];
    }

    protected function getYearsSet(){
        $years = $this->content->pluck('year')->toArray();
        $years = array_unique($years);
        arsort($years);
        return $years;
    }

    protected function getRegionsSet(){
        $regions = Region::join('article_region','regions.id','=','article_region.region_id')
            ->whereIn('article_region.article_id',$this->getContentIds())
            ->select(['regions.id','regions.name'])
            ->distinct()
            ->orderBy('regions.name')
            ->get()->toArray();
        return $regions ?? [];
    }

    protected function getContentIds(){
        return  $this->content->pluck('id');
    }

    public function ofTypes($contentTypes)
    {
        $this->contentTypes = is_array($contentTypes) ? $contentTypes : [$contentTypes];
        return $this;
    }

    public function forTopic($topic){
        $this->topic = $topic;
        return $this;
    }

    public function forYear($year){
        $this->year = $year;
        return $this;
    }

    public function forAuthor(Author $author)
    {
        $this->author = $author;
        return $this;
    }

    public function forRegion(Region $region)
    {
        $this->region = $region;
        return $this;
    }

    public function orderByYear()
    {
        $this->sortField = 'year';
        $this->sortDirection = 'desc';
        return $this;
    }

    public function orderByAuthor()
    {
        $this->sortField = 'authors_string';
        $this->sortDirection = 'asc';
        return $this;
    }

    public function orderByTitle()
    {
        $this->sortField = 'title';
        $this->sortDirection = 'asc';
        return $this;
    }

    public function withPaging($perPage, $currentPage = 1)
    {
        $this->itemsPerPage = $perPage;
        $this->currentPage = $currentPage;
        return $this;
    }


    protected function execute()
    {
        return  $this->content = $this->query->get();
    }

    /**
     * @return mixed
     */
    protected function attachTopicFilter()
    {
        if (!isset($this->topic)) return $this;
        $topicsID = [];
        $topicsCollection = $this->topic instanceof  Topic ? [$this->topic] : $this->topic;
        foreach ($topicsCollection as $topic){
            $topicsID[] = $topic->id;
            if($topic->hasChildren()){
                $topicsID = array_merge($topicsID, $topic->getChildrenIdArray());
            }
        }
        if(sizeof($topicsID) > 1){
            $this->query->whereIn('topic_id', $topicsID);
        } else {
            $this->query->where('topic_id', $topicsID[0]);
        }

        return $this;
    }

    protected function attachContentTypeFilter()
    {
        if (empty($this->contentTypes)) return $this;
        if(sizeof($this->contentTypes) > 1){
            $this->query->whereIn('content_type_id', $this->contentTypes);
        } else {
            $this->query->where('content_type_id', $this->contentTypes[0]);
        }
        return $this;
    }

    protected function attachYearFilter(){
        if( $this->year > 0 ) $this->query->where('year', $this->year);
        return $this;
    }

    protected function attachAuthorFilter(){
        if(isset($this->author)){
            $this->query
                ->join('article_author', 'articles.id', '=' ,'article_author.article_id')
                ->where('author_id',$this->author->id);
        }
        return $this;
    }

    protected function attachRegionFilter(){
        if(isset($this->region)) {
            $this->query
                ->join('article_region', 'articles.id', '=' ,'article_region.article_id')
                ->where('region_id',$this->region->id);
        }
        return $this;
    }

}
