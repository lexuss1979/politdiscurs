<?php


namespace App;




class ContentCollection
{
    protected $content = null;
    protected $paging = [];
    protected $filters = [];

    public function __construct($content, $filters)
    {
        $this->content = $content['data'];
        $this->paging = $content['paging'];
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
