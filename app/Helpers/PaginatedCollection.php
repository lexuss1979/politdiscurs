<?php


namespace App\Helpers;



use Illuminate\Database\Eloquent\Collection;

class PaginatedCollection
{
    protected $data;
    protected $paging;

    public function __construct($data, $perPage = null, $currentPage = 1, $baseUrl = '')
    {
        $content = $data ?  $data : new Collection([]);
        $itemsCount = $content->count();
        $perPage = $perPage > 0 ? $perPage : $itemsCount;
        $total = $itemsCount > 0 ? ceil($itemsCount/$perPage) : 0;

        $paging = [
            'per_page' => $perPage,
            'current' => $currentPage,
            'total' => $total,
            'links' => [
              'next' =>   $currentPage < $total ? $this->getUrl($baseUrl, $currentPage + 1) : false,
              'prev' =>   $currentPage > 1 ? $this->getUrl($baseUrl, $currentPage - 1) : false,
              'current' =>   $this->getUrl($baseUrl, $currentPage)
            ],
            'items_count' => $itemsCount
        ];


        if($perPage < $itemsCount) {
            $chunks = $content->chunk($perPage);
            $content =$chunks[$currentPage-1];
        }
        $this->data = $content;
        $this->paging = $paging;
    }

    public function data()
    {
        return $this->data;
    }

    public function paging()
    {
        return $this->paging;
    }

    public function getUrl($baseUrl, $page){
        $hasQueryPart = strpos($baseUrl,'?') > -1;
        $hasPageParam = strpos($baseUrl,'page=') > -1;
        if($hasQueryPart) {
            return $hasPageParam ? preg_replace('/page=(\d*)/','page='.$page,$baseUrl) : $baseUrl . '&page='.$page;
        } else {
            return $baseUrl . '?page='.$page;
        }
    }

}
