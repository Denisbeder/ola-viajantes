<?php

namespace App\Presenters;

use App\User;
use Illuminate\Support\Str;
use Laracasts\Presenter\Presenter;
use App\Supports\Services\EditorJsService;
use App\Supports\Traits\ImagesPresenterTrait;
use App\Supports\Traits\PublishPresenterTrait;
use App\Supports\Traits\CategoryPresenterTrait;
use App\Supports\Traits\HighlightPresenterTrait;
use App\Supports\Traits\PublisedAtPresenterTrait;

class PostPresenter extends Presenter
{
    use PublishPresenterTrait, CategoryPresenterTrait, HighlightPresenterTrait, ImagesPresenterTrait, PublisedAtPresenterTrait;

    public function subject()
    {
        return $this->hat;
    }
    
    public function speech()
    {
        $text = $this->title . '. ' . $this->description . '. ' . strip_tags($this->bodyHtml(true));
        return html_entity_decode(preg_replace('/\\r|\\n/', '', $text));
    }

    public function bodyBlocks($ignoreRelatedInText = false)
    {
        $bodyArray = json_decode($this->body, true);
        $bodyBlocks = $bodyArray['blocks'] ?? [];
        if (!$ignoreRelatedInText) {          
            $bodyBlocksMiddle = (int) ceil(count($bodyBlocks) / 2);
            array_splice($bodyBlocks, $bodyBlocksMiddle, 0, $this->relatedInTextBlock());
        }
        $bodyArray['blocks'] = $bodyBlocks;
        $body = json_encode($bodyArray, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return $body;
    }

    public function relatedInTextBlock()
    {
        if ($this->relatedInText->isEmpty()) {
            return null;
        }

        $block = [
            'type' => 'readMore',
            'data' => [
                'items' => [
                    [
                        'title' => '',
                        'url' => '',
                    ]
                ]
            ]
        ];

        $items = [];

        foreach ($this->relatedInText as $item) {
            array_push($items, ['title' => $item->title, 'url' => $item->url]);
        }

        $block['data']['items'] = $items;

        return [$block];
    }

    public function bodyHtml($ignoreRelatedInText = false)
    {
        $body = $this->bodyBlocks($ignoreRelatedInText);
        return (bool) strlen($body) ? (new EditorJsService)->outputToHtml($body) : null;
    }

    public function summary($limit = 110)
    {
        $html = $this->bodyHtml(true);
        $htmlDecode = html_entity_decode($html);
        $sanitize = preg_replace('/\r|\n/', '', $htmlDecode);
        $sanitize = preg_replace('/<figcaption.*<\/figurecaption>/', '', $sanitize);
        $sanitize = preg_replace('/\s+/', ' ', $sanitize);
        $sanitize = strip_tags($sanitize);
        $sanitize = trim($sanitize);

        return Str::limit($sanitize, $limit);
    }

    public function url()
    {
        if (is_null($this->page)) {
            return;
        }

        $category = $this->category;
        $pageSlug = '/' . trim($this->page->present()->url, '/');
        $categorySlug = !is_null($category) ? '/' . $category->slug : null;
        $slug = '/' . $this->slug;
        return $pageSlug . $categorySlug . $slug;
    }

    public function getAuthor($key = null)
    {
        $author = $this->author;
        
        if ((bool) strlen($authorName = @$author['name'])) {
            $collect = ['name' => $authorName];
        }

        if (@$author['model'] === 'App\Page') {
            $data = $this->page;
            $avatar = $data->getFirstMediaUrl('avatar');
            $collect = array_merge($data->writer ?? [], ['avatar' => $avatar]);
        }

        if (@$author['model'] === 'App\User') {
            $data = User::find($author['id']);
            $avatar = optional($data)->getFirstMediaUrl('avatar');
            $collect = array_merge($data->writer ?? [], ['avatar' => $avatar]);
        }

        if (is_null($author)) {
            if (!optional($this->user)->uses_writer) {
                if (!empty(array_filter_recursive($this->page->writer ?? []))) {
                    $data = $this->page;
                    $avatar = optional($data)->getFirstMediaUrl('avatar');
                    $collect = array_merge($data->writer ?? [], ['avatar' => $avatar]);
                } else {
                    return null;
                }
            } else {
                $data = $this->user;
                $avatar = optional($data)->getFirstMediaUrl('avatar');
                $collect = array_merge($data->writer ?? [], ['avatar' => $avatar]);
            }    
        }        

        return is_null($key) ? collect($collect ?? []) : collect($collect ?? [])->get($key);
    }

    public function writerAuthor()
    {
        $author = $this->getAuthor();

        if (is_null($author)) {
            return;
        }

        $name = $author->get('name');
        $email = $author->get('email');
        $description = $author->get('description');
        $url = $author->get('url');
        $avatar = $author->get('avatar');

        if ((bool) strlen($url) || (bool) strlen($email) ) {
            $name = sprintf('<a href="%s" target="_blank" title="%s">%s</a>', $url ?? 'mailto:' . $email, $name, $name);
        }

        if ((bool) strlen($avatar)) {
            $avatar = $this->img(@$author->get('avatar'), ['width' => 30, 'height' => 30, 'fit' => 'crop', 'class' => 'img-fluid rounded-pill']);
        } else {
            $avatar = '<i class="lni lni-user"></i>';
        }

        if ((bool) strlen($name)) {
            return $avatar . ' <span>' . $name . '</span>';
        }

        return;
    }
}
