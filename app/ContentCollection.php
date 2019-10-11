<?php


namespace App;




use App\Helpers\PaginatedCollection;

class ContentCollection
{
    protected $content = null;
    protected $paging = [];
    protected $filters = [];

    public function __construct(PaginatedCollection $collection, $filters)
    {
        $this->content = $collection->data();
        $this->paging = $collection->paging();
        $this->filters = $filters;
    }

    public function content(){
        return $this->content;
    }

    public function filters(){
        return $this->filters;
    }

    public function paging()
    {
        return $this->paging;
    }
}
