<?php

use App\Seo;
use App\Page;
use App\Post;
use App\User;
use App\Media;
use App\Video;
use App\Gallery;
use App\Category;
use App\Comment;
use QL\QueryList;
use App\Highlight;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Supports\Services\EditorJsService;
use App\Supports\Services\KeywordGeneratorService;
use App\Supports\Services\UploadedFileFromUrlService;
use Illuminate\Database\Connectors\ConnectionFactory;

class MigrateSeeder extends Seeder
{
    private $conn;
    private $baseUrl = 'https://www.revistadagente.com.br';

    public function __construct()
    {
        $this->conn = $this->conn();
    }

    private function conn()
    {
        $configs = [
                  'driver' => 'mysql',
                  'host' => '206.51.228.226', //'127.0.0.1',
                  'database' => 'revistad_site', //'revistadagente_backup',
                  'username' => 'revistad_root', //'root',
                  'password' => 'bG7~U2}~sByx',
                  'charset' => 'utf8mb4',
                  'collation' => 'utf8mb4_unicode_ci',
            ];
        $connFactory = new ConnectionFactory(app());

        $conn = $connFactory->make($configs);

        return $conn;
    }

    public function run()
    {
        $this->command->info('Migrando Posts...');

        //$this->migrateUsers();
        //$this->migratePages();
        //$this->migrateCategories();
        //$this->migrateVideos();
        //$this->migratePosts();
        $this->migrateComments();
        //$this->migrateGallery();
    }

    public function migrateUsers()
    {
        $table = 'users';
        $datas = $this->conn->table($table)->get();

        $this->resetDataTable($table);
            
        foreach ($datas as $data) {
            $save = User::dontCache()->create([
                        'id' => $data->id,
                        'admin' => $data->email === 'denisbeder@gmail.com' ? -1 : 0,
                        'user_id' => null,
                        'name' => $data->name,
                        'username' => Str::slug(head(explode(' ', $data->name))),
                        'password' => '',
                        'remember_token' => $data->remember_token,
                        'email' => $data->email,
                        'publish' => 1,
                  ]);

            $save->toBase()->where('id', $data->id)->update(['password' => $data->password]);
        }
    }

    public function migratePages()
    {
        $table = 'pages';
        $datas = $this->conn->table($table)->get();

        $managerMap = collect([
                  'videos' => 'App\Video',
                  'lives' => 'App\Video',
                  'youtubers' => 'App\Video',
                  'colunas' => 'App\Video',
                  'tv-dagente' => 'App\Video',
                  'noticias' => 'App\Post',
                  'moda-tendencias-lancamentos' => 'App\Post',
                  'contato' => 'App\Form',
                  'fotos' => 'App\Gallery',
                  'galeria-de-fotos' => 'App\Gallery',
            ]);
            
            
        $this->resetDataTable($table);
            
        foreach ($datas as $data) {
            Seo::where('seoable_id', $data->id)->where('seoable_type', 'App\\Page')->delete();

            $pageType = head(explode('/', trim($data->slug, '/')));
            $manager = $managerMap->get($pageType) !== null ? ['type' => $managerMap->get($pageType)] : null;
            $slug = $data->slug;

            if ($data->slug === 'colunas' || $data->slug === 'youtubers') {
                $slug = $data->title;
            }

            $save = Page::dontCache()->create([
                        'id' => $data->id,
                        'user_id' => 1,
                        'title' => $data->title,
                        'slug' => Str::slug($slug),
                        'manager' => $manager,
                        'publish' => $data->status,
                        'created_at' => $data->created_at,
                        'updated_at' => $data->updated_at,
                  ]);

            $save->seo()->create([
                        'title' => $data->seo_title,
                        'description' => $data->seo_description,
                        'keywords' => $data->seo_keywords,
                  ]);
        }
    }

    public function migrateCategories()
    {
        $table = 'posts_categories';
        $datas = $this->conn->table($table)->whereNotNull('page_id')->get();

        //$this->resetDataTable('categories');

        foreach ($datas as $data) {
            $this->command->info('Migrando Categorias - ID:' . $data->id . ' - Nome: ' . $data->title);

            Category::dontCache()->updateOrCreate(['id' => $data->id], [
				'id' => $data->id,
				'user_id' => $data->user_id,
				'page_id' => $data->page_id,
				'title' => $data->title,
				'slug' => $this->fixLenghtString($data->slug),
				'publish' => 1,
			]);
        }
    }

    public function migrateComments()
    {
        $table = 'comments';
        $datas = $this->conn->table($table)->get();

        //$this->resetDataTable('comments');

        foreach ($datas as $data) {
            $this->command->info('Migrando Comentários - ID:' . $data->id . ' - Nome: ' . $data->name);

            Comment::dontCache()->updateOrCreate(['id' => $data->id], [
				'id' => $data->id,
				'commentable_type' => 'App\Post',
				'commentable_id' => $data->post_id,
				'name' => $data->name,
				'email' => $data->email,
				'text' => $data->body,
				'ip' => '127.0.0.1',
				'device' => '--',
				'publish' => $data->status,
                'created_at' => $data->created_at,
			    'updated_at' => $data->updated_at,
			]);
        }
    }

    public function migrateVideos()
    {
        $pages = Page::where('manager->type', 'App\\Video')->get();
        $table = 'posts';
        $datasPostsInVideos = $this->conn->table($table)->where('body', '<>', '')->whereIn('page_id', [6,17,19])->get();
        $datas = $this->conn->table($table)->whereIn('page_id', $pages->pluck('id'))->get();
		$datas = $datas->merge($datasPostsInVideos);
		$pagesUsePost = Page::firstWhere('slug', 'like', 'noticias%');
            
        $this->resetDataTable('videos');

        foreach ($datas as $data) {          
            if ((bool) strlen($data->body)) {	
				$this->command->info('Migrando Vídeos/POSTS('.$pagesUsePost->id.') - ID:' . $data->id . ' - Título: ' . $data->title);			
				if ($pagesUsePost !== null) {
					$this->buildData($data, $pagesUsePost->id);
				}
            } else {
				$this->command->info('Migrando Vídeos - ID:' . $data->id . ' - Título: ' . $data->title);

				$save = Video::dontCache()->updateOrCreate(['id' => $data->id], [
					'id' => $data->id,
					'user_id' => $data->user_id,
					'page_id' => $data->page_id,
					'title' => $data->title,
					'slug' => $this->fixLenghtString($data->slug),
					'script' => $this->makeEmbed($data->video),
					'url' => $this->fixLenghtString($data->video),
					'published_at' => $data->created_at,
					'created_at' => $data->created_at,
					'updated_at' => $data->updated_at,
					'publish' => $data->status,
			  	]);

                Media::dontCache()->where('model_type', 'App\Video')->where('model_id', $data->id)->delete();

				if ((bool) strlen($data->cover_image_file) || !$save->hasMedia('image') && is_url($data->cover_image_file)) {
                    $path = ltrim(parse_url($data->cover_image_file, PHP_URL_PATH), '/');
                    $path = str_replace('uploads/posts/', 'videos/', $path);
                    $path = '/public/' . $path;
					$pathImage = trim($this->baseUrl . '/' . ltrim($data->cover_image_file, '/'), '.');
                    
                    //if (!Storage::exists($path)) {
                        if (fileExists($pathImage)) {
                            $mimeType = $this->getUrlMimeType($pathImage);
    
                            if (Str::startsWith($mimeType, 'image')) {
                                Media::where('model_type', 'App\Video')->where('model_id', $data->id)->delete();
    
                                $save->addMediaFromUrl($pathImage)
                                                ->toMediaCollection('image');
                            }
                        }
                    //}
				}
			}       
        }
    }

    public function migrateGallery()
    {
        $table = 'posts';
        $pagesUsePost = Page::where('manager->type', 'App\\Gallery')->get()->pluck('id');
        $datas = $this->conn->table($table)->where('id', '>=', 3993)->whereIn('page_id', $pagesUsePost)->orderby('id');

        //$this->resetDataTable('galleries');

        foreach($datas->get() as $data) {
            $this->command->info('Migrando Galerias - ID:' . $data->id . ' - Título: ' . $data->title);

            $save = Gallery::dontCache()->updateOrCreate(['id' => $data->id], [
                'user_id' => $data->user_id,
                'page_id' => $data->page_id,
                'title' => $data->title,
                'slug' => $this->fixLenghtString($data->slug),
                'description' => trim(strip_tags($data->body)),
                'publish' => $data->status,
                'published_at' => $data->created_at,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ]);
    
            $save->seo()->create([
                            'description' => $data->description,
                            'keywords' => $this->fixLenghtString((new KeywordGeneratorService)->generateKW(strip_tags($data->body))),
                    ]);
    
            Media::dontCache()->where('model_type', 'App\Gallery')->where('model_id', $data->id)->delete();
                    

            $totalPhotos = $this->conn->table('posts_photos_gallery')->where('post_id', $data->id)->count();
            $this->conn->table('posts_photos_gallery')
                ->where('post_id', $data->id)
                ->orderby('order')
                ->get()
                ->map(function ($item) {
                    return ['path' => $item->file, 'caption' => null];
                })
                ->prepend(['path' => $data->cover_image_file, 'caption' => $data->cover_image_legend])
                ->each(function ($item, $key) use ($save, $totalPhotos) {    
                    $this->command->info('----Importando imagem ' . ($key + 1) . ' de ' . $totalPhotos);
                    
                    $pathname = ltrim(parse_url($item['path'], PHP_URL_PATH), '/');
                    $pathImage = '/' . $pathname;
                    $pathImage = trim($this->baseUrl . '/' . ltrim($item['path'], '/'), '.');						
                    $path = str_replace('uploads/posts/', 'galleries/', $pathname);
                    $path = '/public/' . $path;
    
                    //if (!Storage::exists($path)) {                                
                        if ((bool) strlen($item['path']) || !$save->hasMedia('images')) {
                            if (fileExists($pathImage) && is_url($pathImage)) {
                                $mimeType = $this->getUrlMimeType($pathImage);
                                if (Str::startsWith($mimeType, 'image')) {
                                    $save->addMediaFromUrl($pathImage)
                                                ->withCustomProperties(['caption' => $item['caption']])
                                                ->toMediaCollection('images');
                                }
                            }
                        }
                    //}
                });
    
            $this->getImgsFromHtml($data->body)->each(function ($item) {
                $pathname = ltrim(parse_url($item['path'], PHP_URL_PATH), '/');
                $pathImage = '/' . $pathname;
                $pathImage = trim($this->baseUrl . $pathImage, '.');
                $path = str_replace('uploads/posts/', 'galleries/', $pathname);
                $path = '/public/' . $path;	
    
                //if (!Storage::exists($path)) {
                   if (fileExists($pathImage) && is_url($pathImage)) {
                        $mimeType = $this->getUrlMimeType($pathImage);
                        if (Str::startsWith($mimeType, 'image')) {
                            $uploadFile = (new UploadedFileFromUrlService($pathImage))->create();
                            $uploadFile->storeAs('public', pathinfo($pathImage, PATHINFO_BASENAME));
                        }
                    }
                //}			
            });
        }
    }

    public function migratePosts()
    {
        $table = 'posts';
        $pagesUsePost = Page::where('manager->type', 'App\\Post')->get()->pluck('id');
        $datas = $this->conn->table($table)->whereIn('page_id', $pagesUsePost)->orderby('id');

        $lastIdPosts = optional(Post::latest('id')->limit(1)->first())->id;
        if (!is_null($lastIdPosts)) {
            $datas->where('id', '>=', $lastIdPosts);
        }

        //$this->resetDataTable('posts');

        return $this->savePosts($datas->get());
    }

    public function savePosts($datas)
    {
        $datasTotal = $datas->count();
        $chunk = 100;
        $stackTotal = ceil($datasTotal / $chunk);
        $stack = 1;
        $startAt = now();
        $datasChunk = $datas->chunk(100);

        $this->command->info('Inicio em ' . $startAt);

        foreach ($datasChunk as $items) {
            $this->command->info('Processando ' . $chunk . ' Items do Lote ' . $stack++ . ' de ' . $stackTotal);
            $i = 1;
            foreach ($items as $data) {
                $this->command->info('Migrando Post ' . $i++ . ' - ID:' . $data->id . ' - Título: ' . $data->title);

				$this->buildData($data);
            }
        }

        $this->command->info('Inicio em ' . $startAt . ' Finalizado em ' . now());
    }

	public function buildData($data, $forcePageID = null)
    {		
		$body = (new EditorJsService)->outputToJson($data->body, function ($item) {
			return str_replace('src="/uploads/images/', 'src="/media/', $item);
		});

		if ((bool) strlen($data->video)) {
			$dataVideo = [
				'type' => 'raw',
				'data' => [
					'html' => $this->makeEmbed($data->video)
				]
			];
			$bodyDecode = json_decode($body, true);
			array_push($bodyDecode['blocks'], $dataVideo);
			$body = json_encode($bodyDecode, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		}

		$allowCategories = Category::all()->pluck('id')->toArray();

		$save = Post::dontCache()->updateOrCreate(['id' => $data->id], [
			'user_id' => $data->user_id,
			'category_id' => in_array($data->category_id, $allowCategories) ? $data->category_id : null,
			'page_id' => $forcePageID ?? $data->page_id,
			'title' => $data->title,
			'slug' => $this->fixLenghtString($data->slug),
			'description' => $data->description,
			'body' => $body,
			'cover_inside' => $data->cover_image_allow_image_inside_post,
			'author' => (bool) strlen($data->author) ? ['type' => 'static', 'name' => $data->author] : null,
			'commentable' => $data->allow_comments,
			'publish' => $data->status,
			'published_at' => $data->created_at,
			'created_at' => $data->created_at,
			'updated_at' => $data->updated_at,
		]);

		$save->seo()->create([
						'description' => $data->description,
						'keywords' => $this->fixLenghtString((new KeywordGeneratorService)->generateKW(strip_tags($data->body))),
				]);

		Highlight::dontCache()->where('highlightable_type', 'App\Post')->where('highlightable_id', $data->id)->delete();

		$save->highlight()->create([
						'position' => $data->featured,
				]);

		Media::dontCache()->where('model_type', 'App\Post')->where('model_id', $data->id)->delete();

		$this->conn->table('posts_photos_gallery')
            ->where('post_id', $data->id)
            ->orderby('order')
            ->get()
            ->map(function ($item) {
                return ['path' => $item->file, 'caption' => null];
            })
            ->prepend(['path' => $data->cover_image_file, 'caption' => $data->cover_image_legend])
            ->each(function ($item) use ($save) {                           
                $pathname = ltrim(parse_url($item['path'], PHP_URL_PATH), '/');
                $pathImage = '/' . $pathname;
                $pathImage = trim($this->baseUrl . '/' . ltrim($item['path'], '/'), '.');						
                $path = str_replace('uploads/', '', $pathname);
                $path = '/public/' . $path;

                //if (!Storage::exists($path)) {                                
                    if ((bool) strlen($item['path']) || !$save->hasMedia('images')) {
                        if (fileExists($pathImage) && is_url($pathImage)) {
                            $mimeType = $this->getUrlMimeType($pathImage);
                            if (Str::startsWith($mimeType, 'image')) {
                                $save->addMediaFromUrl($pathImage)
                                            ->withCustomProperties(['caption' => $item['caption']])
                                            ->toMediaCollection('images');
                            }
                        }
                    }
                //}
            });

		$this->getImgsFromHtml($data->body)->each(function ($item) {
			$pathname = ltrim(parse_url($item['path'], PHP_URL_PATH), '/');
			$pathImage = '/' . $pathname;
			$pathImage = trim($this->baseUrl . $pathImage, '.');
            $path = str_replace('uploads/', '', $pathname);
            $path = '/public/' . $path;	

            //if (!Storage::exists($path)) {
               if (fileExists($pathImage) && is_url($pathImage)) {
                    $mimeType = $this->getUrlMimeType($pathImage);
                    if (Str::startsWith($mimeType, 'image')) {
                        $uploadFile = (new UploadedFileFromUrlService($pathImage))->create();
                        $uploadFile->storeAs('public', pathinfo($pathImage, PATHINFO_BASENAME));
                    }
                }
            //}			
		});
    }

    public function getImgsFromHtml($html)
    {
        $ql = QueryList::html($html);

        $imgsCollect = collect([]);

        $ql->find('img')->map(function ($img) use ($imgsCollect) {
            $imgSrc = stripslashes($img->src);
            $imgSrc = str_replace('"', '', $imgSrc);
            $imgsCollect->push(['path' => $imgSrc]);
        });

        return $imgsCollect;
    }

    public function fixLenghtString($str)
    {
        $str = strip_tags($str);
        return Str::limit($str, 191, '');
    }

    public function makeEmbed($url)
    {
        $parseUrl = parse_url($url);
        $id = '';
        $scriptYoutube = '<iframe width="560" height="315" src="https://www.youtube.com/embed/%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

        if (empty(array_filter($parseUrl))) {
            return null;
        }

        if (Str::contains($parseUrl['host'], 'youtu')) {
            if (isset($parseUrl['query'])) {
                parse_str($parseUrl['query'], $output);
                if (isset($output['v'])) {
                    $id = $output['v'];
                }
            } else {
                $id = trim($parseUrl['path'], '/');
            }
        }

        $result = sprintf($scriptYoutube, $id);

		return $result;
    }

    public function resetDataTable($table)
    {
        DB::disableQueryLog();
        DB::table($table)->delete();
        DB::unprepared("ALTER TABLE {$table} AUTO_INCREMENT = 1;");
    }

    public function getUrlMimeType($url)
    {
        $buffer = file_get_contents($url);
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        return $finfo->buffer($buffer);
    }
}
