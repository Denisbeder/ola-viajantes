<?php

use App\Page;
use App\Post;
use QL\QueryList;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Supports\Services\EditorJsService;

class PostsSeeder extends Seeder
{
      public function run()
      {
            DB::disableQueryLog();

            DB::table('posts')->where('page_id', 1)->delete();
            DB::unprepared("ALTER TABLE posts AUTO_INCREMENT = 1;");
            DB::table('media')->where('model_type', 'App\\Post')->delete();
            DB::table('highlights')->where('highlightable_type', 'App\\Post')->delete();
            Storage::deleteDirectory('public/posts');
            
            $page = Page::firstOrCreate(['slug' => 'noticias'], ['publish' => 1, 'title' => 'Notícias', 'slug' => 'noticias', 'manager' => ['type' => 'App\Post']]);
            
            $datas = $this->crawlerDatas($page->id);

            foreach ($datas as $data) {               
                  $this->command->info('Inserindo: ' . $data['title']);

                  $save = Post::create(Arr::except($data, 'img'));

                  $save->highlight()->create(['position' => rand(1, 8)]);

                  if ((bool) strlen($data['img'])) {
                        try {
                              $save->addMediaFromUrl($data['img'])->toMediaCollection('images');                 
                        } catch (Exception $e) {

                        }
                  }
            }
      }

      private function crawlerDatas($pageId)
      {
            /* $url = 'https://www.panrotas.com.br/destinos/parques-tematicos/2021/12/animais-reabilitados-pelo-seaworld-sao-transferidos-para-aquario_186444.html';
            $ql = QueryList::get($url);
            $bodyHtml = $ql->find('.txt-body')->html();
            $bodyHtml = str_replace(["\r", "\n"], '', $bodyHtml);
            $bodyHtml = '<div>' . $bodyHtml . '</div>';
            $bodyHtml2 = preg_replace('/<figure[^>]*>.+?\X+?(<img[^>]*>).*?\X+?<\/figure>/', '<figure class="show-image show-image--stretched">$1</figure>', $bodyHtml);
            dd($bodyHtml, $bodyHtml2);
            $body = (new EditorJsService)->outputToJson($bodyHtml);

            dd($bodyHtml, $body); */
            
            $this->command->info('Buscando Posts...');

            $sourceBaseUrl = 'https://www.panrotas.com.br';
            $bagUrls = collect([]);
            $bagPosts = collect([]);            
            $sourceUrl = $sourceBaseUrl . '/service-news/more-news/models/GET-news.asp?qtd=50&channels=88&category=100%2C97%2C99%2C3%2C98%2C5%2C94%2C96&orderBy=latest';

            $ql = QueryList::get($sourceUrl, null, [
                  'header' => [
                        'Referer' => 'https://www.panrotas.com.br/noticias/destinos',
                        'Accept'     => 'application/json',
                  ]
            ]);

            $datas = json_decode($ql->getHtml(), true);
            $bagUrls = collect($datas['news']);

            $bagUrls->each(function ($item) use ($bagPosts, $pageId, $sourceBaseUrl) {
                  $url = $sourceBaseUrl . $item['url'];
                  $ql = QueryList::get($url);

                  $img = $ql->find('.thumb img')->attr('src');
                  $title = $item['title'];
                  $bodyHtml = $ql->find('.txt-body')->html();
                  $bodyHtml = str_replace(["\r", "\n"], '', $bodyHtml);
                  $bodyHtml = '<div>' . $bodyHtml . '</div>';
                  $bodyHtml = preg_replace('/<figure[^>]*>.+?\X+?(<img[^>]*>).*?\X+?<\/figure>/', '<figure class="show-image show-image--stretched">$1</figure>', $bodyHtml);
                  $body = (new EditorJsService)->outputToJson($bodyHtml);
                  $createdAt = Carbon::createFromFormat('d/m/Y H:i:s', trim($item['publishDate']));

                  $data = [
                        'title' => $title,
                        'body' => $body,
                        'published_at' => $createdAt,
                        'source' => 'PANROTAS',
                        'publish' => 1,
                        'user_id' => 1,
                        'page_id' => $pageId,
                        'cover_inside' => 0,
                        'img' => $img,
                  ];

                  $bagPosts->push($data);
            });

            return $bagPosts;
      }
}
