<?php

use App\Seo;
use App\Page;
use App\Post;
use App\User;
use App\Media;
use App\Video;
use App\Gallery;
use App\Category;
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

class FixSeeder extends Seeder
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
        $this->command->info('Corrigindo Items...');

        //$this->fixAuthor();
        //$this->fixBodyPosts();
        $this->fixPathImagesPosts();
    }

    public function fixAuthor()
    {
        $posts = Post::whereNotNull('author')->each(function ($item) {
            if (is_string($item->author)) {
                $decode = json_decode($item->author, true);
                $this->command->info('Atualizando author - ID:' . $item->id . ' - Título: ' . $item->title);
                $item->update([
                    'author' => $decode
                ], ['timestamps' => false]);
            }
        });
    }

    public function fixPathImagesPosts()
    {
        Post::all()->each(function ($item) {
            $body = $item->body;
            $body = str_replace('src="/uploads/images/', 'src="/media/', $body);
            $body = str_replace('/uploads/', '/media/', $body);
            $body = preg_replace('/\/media\/(.*\/[0-9]+\/)/', '/media/', $body);
            $this->command->info('Atualizando ID:' . $item->id . ' - Título: ' . $item->title);
            $item->update(['body' => $body], ['timestamps' => false]);
        });

    }

    public function fixBodyPosts()
    {
        $table = 'posts';
        $pagesUsePost = Page::where('manager->type', 'App\\Post')->get()->pluck('id');
        $datas = $this->conn->table($table)->whereIn('page_id', $pagesUsePost)->orderby('id')->chunk(200, function ($datas) {
            foreach($datas as $data) {                  
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

                $post = Post::find($data->id);

                if ($post->exists) {
                    $this->command->info('Atualizando ID:' . $data->id . ' - Título: ' . $data->title);
                    $post->update([
                        'body' => $body
                    ], ['timestamps' => false]);
                }
            }
        });
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
}
