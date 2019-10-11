<?php


namespace App\Helpers;



use Illuminate\Database\Eloquent\Collection;

class PaginatedCollection
{
    protected $data;
    protected $paging;

    public function __construct($data, $perPage = null, $currentPage = 1)
    {
        $content = $data ?  $data : new Collection([]);
        $itemsCount = $content->count();
        $perPage = $perPage > 0 ? $perPage : $itemsCount;
        $total = $itemsCount > 0 ? ceil($itemsCount/$perPage) : 0;

        $paging = [
            'per_page' => $perPage,
            'current' => $currentPage,
            'total' => $total,
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

}
