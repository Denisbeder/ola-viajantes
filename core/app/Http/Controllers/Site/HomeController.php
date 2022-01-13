<?php

namespace App\Http\Controllers\Site;

use App\Video;
use App\Advert;
use App\Gallery;
use App\Highlight;
use App\Supports\Traits\SeoGenerateTrait;
use App\Supports\Services\MostViewedService;
use App\Supports\Services\LatestAllRecordsService;

class HomeController extends Controller
{
    use SeoGenerateTrait;

    private $excludeIds;

    public function __construct()
    {
        parent::__construct();
        
        $this->excludeIds = collect([]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mostViews = (new MostViewedService)->get(8, ['destinations', 'destinations.media']);
        $mostViewsDestinations = $mostViews->pluck('destinations')->flatten();

        $posts = $this->getPosts();
        //$medias = $this->getMedias();
        //$adverts = $this->getAdverts();
        $latest = $this->getLatest();

        $seo = $this->seoSetDescription(optional(app('settingService')->get('seo'))->get('description'))
            ->seoSetKeywords(optional(app('settingService')->get('seo'))->get('keywords'))
            ->seoForIndexPage();

        return view('site.home.index')->with($posts)->with(compact('latest', 'seo', 'mostViews', 'mostViewsDestinations'));
    }

    private function getLatest()
    {
        return (new LatestAllRecordsService)->excludeIds($this->excludeIds)->limit(3)->get()->take(3);
    }

    private function getGalleries()
    {
        return Gallery::with('media')->whereHas('page', function ($query) {
            $query->where('publish', 1);
        })->scheduled()->latest()->limit(9)->get();
    }

    private function getAdverts()
    {
        return Advert::with('media')->whereHas('page', function ($query) {
            $query->where('publish', 1);
        })->scheduled()->limit(10)->latest()->get()->shuffle();
    }

    private function getMedias()
    {
        $galleries =  $this->getGalleries();
        $videos =  $this->getVideos();
        $datas = $galleries->merge($videos)->sortByDesc('created_at')->take(9);

        return $datas;
    }

    private function getVideos()
    {
        $excludeIds = $this->excludeIds->where('type', 'App\Video')->pluck('id');
        $datas = Video::with('media')->whereHas('page', function ($query) {
            $query->where('publish', 1);
        })->scheduled()->whereNotIn('id', $excludeIds)->latest()->limit(9)->get();

        $datas->each(function ($item) {
            $this->excludeIds->push(['id' => $item->id, 'type' => get_class($item)]);
        });

        return $datas;
    }

    private function getPosts()
    {
        // Todas as posições de notícias na Home
        $configs = [
            ['position' => 1, 'limit' => 1,],
            ['position' => 2, 'limit' => 1,],
            ['position' => 3, 'limit' => 1,],
            ['position' => 4, 'limit' => 1,],
            ['position' => 5, 'limit' => 1,],
            ['position' => 6, 'limit' => 1,],
            ['position' => 7, 'limit' => 1,],
            ['position' => 8, 'limit' => 1,],
        ];

        $datas = $this->getDatas($configs);

        collect($datas)->flatMap(function ($values) {
            return $values->each(function ($item) {
                $this->excludeIds->push(['id' => $item->id, 'type' => get_class($item)]);
            });
        });

        return $datas;
    }

    private function getDatas($configs)
    {
        // Pegar somente items já publicados
        $collectBasePublished = $this->queryPosts(head($configs)['position'], head($configs)['limit']);
        foreach (array_slice($configs, 1) as $config) {
            $collectCurrentPublished = $this->queryPosts($config['position'], $config['limit']);

            $collectUnionPublished = $collectBasePublished->union($collectCurrentPublished);
        }

        // Pegar somente items agendados
        $collectBaseScheduled = $this->queryPosts(head($configs)['position'], head($configs)['limit'], 'scheduled');
        foreach (array_slice($configs, 1) as $config) {
            $collectCurrentScheduled = $this->queryPosts($config['position'], $config['limit'], 'scheduled');

            $collectUnionScheduled = $collectBaseScheduled->union($collectCurrentScheduled);
        }

        // Une os items agendados com os publicados
        $collect = $collectUnionScheduled->get()->merge($collectUnionPublished->get());

        foreach ($configs as $config) {
            // Filtra e retorna somente os registros que estiverem com a data de publicação válida com a data e hora atual
            $datas["postsP{$config['position']}"] = $collect
                ->where('position', $config['position'])
                ->pluck('highlightable')
                ->filter(function ($item) {
                    return ($item->published_at <= now()) && ($item->unpublished_at >= now() || $item->unpublished_at === null);
                })
                ->take($config['limit']);
        }

        return $datas;
    }
    
    private function queryPosts($position, $limit, $queryType = 'published')
    {
        $queryPublished = Highlight::whereHasMorph('highlightable', ['App\Post', 'App\Video', 'App\Gallery'], function ($query) {
            $query->with('media', 'page', 'page.ancestors', 'category')->whereHas('page', function ($query) {
                $query->where('publish', 1);
            })->published();
        });

        $queryScheduled = Highlight::whereHasMorph('highlightable', ['App\Post', 'App\Video', 'App\Gallery'], function ($query) {
            $query->with('media', 'page', 'page.ancestors', 'category')->whereHas('page', function ($query) {
                $query->where('publish', 1);
            })->where('published_at', '>=', now());
        });

        $query = $queryType === 'published' ? $queryPublished : $queryScheduled;
        $limit = $queryType !== 'published' ? 5 : $limit;
        
        $query->with(['highlightable' => function ($morphTo) {
            $morphTo->morphWith([
                    'App\Post' => ['media', 'page', 'page.ancestors', 'category'],
                    'App\Video' => ['media', 'page', 'page.ancestors', 'category'],
                    'App\Gallery' => ['media', 'page', 'page.ancestors', 'category'],
                ]);
        }])
        ->where('position', $position)
        ->limit($limit)
        ->orderBy('updated_at', 'desc');

        return $query;
    }
}
