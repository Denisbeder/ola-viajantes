<?php

namespace App\Supports\Services;

use Closure;
use QL\QueryList;
use Illuminate\Support\Arr;

class EditorJsService
{
    /**
     * Convert array blocks content to html.
     *
     * @param  string  $content
     * @return string
     */
    public function outputToHtml(string $content)
    {
        $content = json_decode($content, 1);
        $blocks = Arr::get($content, 'blocks');

        $renderedBlocks = [];

        /**
         * Using PHP renderer for Articles
         */
        for ($i = 0; $i < count($blocks); $i++) {
            $renderedBlocks[] = view(
                'supports.editorjs.plugins.' . $blocks[$i]['type'],
                [
                    'block' => (object) $blocks[$i]['data']
                ]
            )->render();
        }

        return implode('', $renderedBlocks);
    }

    /**
     * Convert array content to json.
     *
     * @param  string  $content
     * @return string
     */
    public function outputToJson($content, ?Closure $callback = null)
    {
        $content = !is_array($content) ? $this->splitTagsHtml($content, $callback) : $content; 
        $blocks = [];

        foreach ($content as $item) {
            if (isset($item['type'])) {
                switch ($item['type']) {
                    case 'paragraph':
                        $data = [
                            'type' => 'paragraph',
                            'data' => [
                                'text' => @$item['data']
                            ]
                        ];
                        array_push($blocks, $data);
                        break;
                }
            } else {
                $data = [
                    'type' => 'paragraph',
                    'data' => [
                        'text' => $item
                    ]
                ];
                array_push($blocks, $data);
            }
        }

        $result = array_filter_recursive(['blocks' => $blocks]);

        return !empty($result) ? json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : null;
    }

    /**
     * Convert html string content to array.
     *
     * @param  string  $content
     * @return array
     */
    protected function splitTagsHtml($string, ?Closure $callback = null)
    {
        $ql = QueryList::html($string);

        $parse = $ql->find('>*')
        ->htmlOuters()
        ->map(function ($item) {
            $str = $item;
            $str = trim(strip_tags($str, '<iframe><figure><img><h1><h2><h3><h4><h5><h6><em><i><b><strong><u><br><hr><ul><li><ol><dl><dt><dd><a><center><table><tr><td><tbody><thead><tfooter>'));
            $str = nl2br($str);
            $str = preg_replace('/\n|\t|\r/', '', $str);
            if ($this->isJson($str)) {
                $str = str_replace('"', '', $str);
                $str = preg_replace('/","|"]/', '', $str);
                $str = json_decode('"'.str_replace('"', '\\"', $str).'"');
            }
            return $str;
        })
        ->filter()
        ->unique();

        if (!is_null($callback)) {            
            $parse = $parse->map($callback);
        }

        if ($parse->isEmpty()) {
            preg_match_all('/\<\w[^<>]*?\>([^<>]+?\<\/\w+?\>)?|\<\/\w+?\>/i', $string, $result);
            $result = $result[0];
            return $result;
        }

        return $parse;
    }

    private function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
     }
}
