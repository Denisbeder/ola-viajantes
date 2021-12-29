<?php

namespace App\Http\Controllers\Site;

use App\Post;
use App\Video;
use App\Advert;
use App\Gallery;
use App\Listing;
use App\Promotion;
use Illuminate\Http\Request;
use App\Supports\Traits\SeoGenerateTrait;
use Illuminate\Database\Eloquent\Collection;
use App\Supports\Services\KeywordGeneratorService;

class SearchController extends Controller
{
    use SeoGenerateTrait;

    public $post;
    public $gallery;
    public $video;
    public $advert;
    public $listing;
    public $promotion;

    public function __construct(Post $post, Gallery $gallery, Video $video, Advert $advert, Listing $listing, Promotion $promotion)
    {
        parent::__construct();
        
        $this->post = $post;
        $this->gallery = $gallery;
        $this->video = $video;
        $this->advert = $advert;
        $this->listing = $listing;
        $this->promotion = $promotion;
    }

    public function index(Request $request)
    {
        $queryString = filter_var($request->query('s'));

        $collectPost = $this->searchInPost($queryString);
        $collectVideo = $this->searchInVideo($queryString);
        $collectGallery = $this->searchInGallery($queryString);
        $collectAdvert = $this->searchInAdvert($queryString);
        $collectListing = $this->searchInListing($queryString);
        $collectPromotion = $this->searchInPromotion($queryString);

        $datas = new Collection([]);
       
        if ($collectPost->isNotEmpty()) {
            $datas = $datas->merge($collectPost);
        }

        if ($collectVideo->isNotEmpty()) {
            $datas = $datas->merge($collectVideo);
        }

        if ($collectGallery->isNotEmpty()) {
            $datas = $datas->merge($collectGallery);
        }

        if ($collectAdvert->isNotEmpty()) {
            $datas = $datas->merge($collectAdvert);
        }

        if ($collectListing->isNotEmpty()) {
            $datas = $datas->merge($collectListing);
        }

        if ($collectPromotion->isNotEmpty()) {
            $datas = $datas->merge($collectPromotion);
        }

        $titlesInline = $datas->take(500)->pluck('title')->implode('|');
        $keywords = (new KeywordGeneratorService)->generateKW($titlesInline);
        $seo = $this->seoSetTitle('Resultado da busca por ' . $queryString)
            ->seoSetDescription('Exibindo todos os resultados para a busca ' . $queryString)
            ->seoSetType('SearchResultsPage')
            ->seoSetKeywords($keywords)
            ->seoForIndexPage();

        $datas = $datas->paginate();        

        return view('site.search.index', compact('datas', 'seo'));
    }

    private function searchInPost($queryString)
    {
        return $this->post
            ->search($queryString)
            ->get()
            ->filter(function ($item) {
                return ($item->published_at <= now()) && ($item->unpublished_at >= now() || $item->unpublished_at === null);
            });
    }

    private function searchInAdvert($queryString)
    {
        return $this->advert
            ->search($queryString)
            ->get();
    }

    private function searchInListing($queryString)
    {
        return $this->listing
            ->search($queryString)
            ->get()
            ->filter(function ($item) {
                return ($item->published_at <= now()) && ($item->unpublished_at >= now() || $item->unpublished_at === null);
            });
    }

    private function searchInPromotion($queryString)
    {
        return $this->promotion
            ->search($queryString)
            ->get()
            ->filter(function ($item) {
                return ($item->published_at <= now()) && ($item->unpublished_at >= now() || $item->unpublished_at === null);
            });
    }

    private function searchInVideo($queryString)
    {
        return $this->video
            ->search($queryString)
            ->get();
    }

    private function searchInGallery($queryString)
    {
        return $this->gallery
            ->search($queryString)
            ->get();
    }
}
