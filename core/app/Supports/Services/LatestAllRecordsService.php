<?php

namespace App\Supports\Services;

use App\Post;
use App\Video;
use App\Gallery;
use Illuminate\Support\Collection;

class LatestAllRecordsService
{
    public $limit = 15;
    public $post;
    public $columnPost;
    public $gallery;
    public $video;
    public $excludeIds;

    public function __construct()
    {
        $this->post = new Post;
        $this->gallery = new Gallery;
        $this->video = new Video;
        $this->excludeIds = collect([]);
    }

    public function excludeIds(Collection $ids)
    {
        $this->excludeIds = $ids;

        return $this;
    }
    
    public function limit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function get()
    {
        $collectPost = $this->getLatestPost();
        $collectPostScheduled = $this->getLatestPost(true);
        $collectVideo = $this->getLatestVideo();
        $collectVideoScheduled = $this->getLatestVideo(true);
        $collectGallery = $this->getLatestGallery();
        $collectGalleryScheduled = $this->getLatestGallery(true);

        $datas = $collectPost
            ->merge($collectPostScheduled)
            ->merge($collectVideo)
            ->merge($collectVideoScheduled)
            ->merge($collectGallery)
            ->merge($collectGalleryScheduled)
            ->sortByDesc('published_at');

        return $datas;
    }

    private function getLatestPost($scheduled = false)
    {       
        $datas = $this->post
            ->with('category', 'media', 'page')            
            ->limit($this->limit)
            ->latest('published_at');

        $excludeIds = $this->excludeIds->where('type', 'App\Post')->pluck('id');

        if ($excludeIds->isNotEmpty()) {
            $datas->whereNotIn('id', $excludeIds);
        }

        if ($scheduled) {
            $collect = $datas->getCollectPublished();
        } else {
            $collect = $datas->published()->get();
        }

        return $collect;
    }

    private function getLatestVideo($scheduled = false)
    {
        $datas = $this->video
            ->with('media', 'page', 'category')
            ->limit($this->limit)
            ->latest();

        $excludeIds = $this->excludeIds->where('type', 'App\Video')->pluck('id');

        if ($excludeIds->isNotEmpty()) {
            $datas->whereNotIn('id', $excludeIds);
        }
        
        if ($scheduled) {
            $collect = $datas->getCollectPublished();
        } else {
            $collect = $datas->published()->get();
        }

        return $collect->sortByDesc('published_at');
    }

    private function getLatestGallery($scheduled = false)
    {
        $datas = $this->gallery
            ->with('media', 'page', 'category')
            ->limit($this->limit)
            ->latest();

        $excludeIds = $this->excludeIds->where('type', 'App\Gallery')->pluck('id');

        if ($excludeIds->isNotEmpty()) {
            $datas->whereNotIn('id', $excludeIds);
        }

        if ($scheduled) {
            $collect = $datas->getCollectPublished();
        } else {
            $collect = $datas->published()->get();
        }

        return $collect->sortByDesc('published_at');
    }
}
