<?php

namespace App\Supports\Services;

use Illuminate\Database\Eloquent\Model;
use App\Supports\Services\KeywordGeneratorService;

class RelatedService 
{
    public $datas;

    public function from(Model $model)
    {
        cache()->remember(md5('related:post:show:' . $model->id), '', function () use ($model) {
            $keywords = $model->seo_keywords;

            if ((bool) !strlen($keywords)) {
                $body = json_decode($model->body, true)['blocks'];
                $body = array_filter($body, function ($item) {
                    return $item['type'] === 'paragraph';
                });
                $body = array_map(function ($item) {
                    return $item['data']['text'];
                }, $body);
                $body = implode(' ', $body);

                $fullText = $model->title;
                $fullText .= $model->description;
                $fullText .= $body; 

                $keywords = $this->getKeywords($fullText);

                if (strlen($keywords) < 1) {
                    $keywords = $this->getKeywordsForce($fullText);
                }
            }
            
            if (strlen($keywords) <= 0) {
                return collect([]);
            }

            $result = $model->search($keywords)->get()->where('id', '<>', $model->id)->take(2);

            $this->datas = $result;
        });

        return $this;
    }

    public function get()
    {
        return $this->datas;
    }

    public function getLinks()
    {
        return $this->datas->map(function ($item) {
            return [
                'url' => $item->present()->url, 
                'title' => $item->title
            ];
        });
    }
    
    public function getKeywords($string)
    {
        $keywords = new KeywordGeneratorService;

        return $keywords->generateKW(strip_tags($string));
    }

    public function getKeywordsForce($string)
    {
        $keywords = new KeywordGeneratorService;
        $str = html_entity_decode($string);
        $str = strip_tags($str);
        $str = trim($str);
        $str = preg_replace('/[^A-zçãíéáàõóú]{3,}/', ' ', $str);
        $str = preg_match_all('/[A-zçãíéáàõóú]{4,}/', $str, $str_output);
        return $keywords->RemoveDuplicates(implode(', ', $str_output[0]));
    }
}
