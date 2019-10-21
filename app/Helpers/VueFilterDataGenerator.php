<?php


namespace App\Helpers;


use App\Author;
use App\ContentType;
use App\Organisation;
use App\Region;
use App\Topic;
use Illuminate\Http\Request;

class VueFilterDataGenerator
{
    private $request;
    private $filters;

    public function __construct(Request $request, array $filters)
    {
        $this->request = $request;
        $this->filters = $filters;
    }

    public function getJSON(){
        $data = [];
        $data = $this->attachAuthors($data);
        $data = $this->attachTopics($data);
        $data = $this->attachRegions($data);
        $data = $this->attachContentTypes($data);
        $data = $this->attachOrganisations($data);
        $data = $this->attachSorts($data);

        return json_encode($data);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function attachSorts(array $data): array
    {
        $sorts = [
                            ['id'=> 1, 'on'=> true, 'title'=> 'Алфавиту'],
                            ['id'=> 2, 'on'=> false, 'title'=> 'Автору'],
                            ['id'=> 3, 'on'=> false, 'title'=> 'Году']
                        ];

            $selected = $this->request->get('sort') ?? null;
            foreach ($sorts as $key => $sort) {
                $sorts[$key]['on'] = $sort['id'] == $selected;
            }
            $data['sorts'] = $sorts;
        return $data;
    }


    /**
     * @param array $data
     * @return array
     */
    protected function attachAuthors(array $data): array
    {
        if (isset($this->filters['authors'])) {
            $selectedAuthorId = $this->request->get('author') ?? null;
            $authors = Author::select('id', 'fio as title')->orderBy('fio')->find($this->filters['authors'])->toArray();
            foreach ($authors as $key => $author) {
                $authors[$key]['on'] = $author['id'] == $selectedAuthorId;
            }
            $data['authors'] = $authors;
        }
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function attachTopics(array $data): array
    {
        if (isset($this->filters['topics'])) {
            $selectedTopics = !$this->request->get('topics') ? [] :  array_map(function($item){return (int)$item;},$this->request->input('topics'));
            $topics = Topic::select('id', 'title')->orderBy('title')->find($this->filters['topics'])->toArray();
            foreach ($topics as $key => $topic) {
                $topics[$key]['on'] = in_array($topic['id'], $selectedTopics);
            }
            $data['topics'] = $topics;
        }
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function attachRegions(array $data): array
    {
        if (isset($this->filters['regions'])) {
            $selectedRegions = $this->request->get('reg') ?? [];
            $regions = Region::select('id', 'name as title')->orderBy('name')->find($this->filters['regions'])->toArray();
            foreach ($regions as $key => $region) {
                $regions[$key]['on'] = $region['id'] == $selectedRegions;
            }
            $data['regions'] = $regions;
        }
        return $data;
    }


    /**
     * @param array $data
     * @return array
     */
    protected function attachContentTypes(array $data): array
    {
        $ALL_TYPES = 'ALL_TYPES';
        if (isset($this->filters['content_types'])) {
            $selected = $this->request->get('types') ?? $ALL_TYPES;
            $ctypes = ContentType::select('id', 'name as title')->find($this->filters['content_types'])->toArray();
            foreach ($ctypes as $key => $ctype) {
                $ctypes[$key]['on'] = $selected == $ALL_TYPES ||  in_array($ctype['id'],$selected) ;
            }
            $data['content_types'] = $ctypes;
        }
        return $data;
    }


    /**
     * @param array $data
     * @return array
     */
    protected function attachOrganisations(array $data): array
    {
        if (isset($this->filters['organisations'])) {
            $selected = $this->request->get('org') ?? null;
            $organisations = Organisation::select('id', 'name as title')->orderBy('name')->find($this->filters['organisations'])->toArray();
            foreach ($organisations as $key => $organisation) {
                $organisations[$key]['on'] = $organisation['id'] == $selected;
            }
            $data['organisations'] = $organisations;
        }
        return $data;
    }


    protected function strToArr($str){
        return explode(',',str_replace(['[',']'],'',$str));
    }

}
