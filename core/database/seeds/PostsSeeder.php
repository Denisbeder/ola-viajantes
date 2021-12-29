<?php

use App\Page;
use App\Post;
use QL\QueryList;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Supports\Services\EditorJsService;

class PostsSeeder extends Seeder
{
      public function run()
      {
            DB::disableQueryLog();

            /* DB::table('posts')->where('page_id', 1)->delete();
            DB::unprepared("ALTER TABLE posts AUTO_INCREMENT = 1;"); */
            
            $page = Page::firstOrCreate(['slug' => 'noticias'], ['publish' => 1, 'title' => 'Notícias', 'slug' => 'noticias', 'manager' => ['type' => 'App\Post']]);
            
            $datas = $this->crawlerDatas($page->id);

            foreach ($datas as $data) {               
                  $this->command->info('Inserindo: ' . $data['title']);

                  $save = Post::create(Arr::except($data, 'img'));

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
            $this->command->info('Buscando Posts...');

            $totalPages = 5;
            $sourcePage = '1';
            $sourceBaseUrl = 'https://agenciabrasil.ebc.com.br';
            $bagUrls = collect([]);
            $bagPosts = collect([]);
            
            for ($sourcePage; $sourcePage <= $totalPages; $sourcePage++) {
                  $sourceUrl = $sourceBaseUrl . '/geral?page=' . $sourcePage;

                   $ql = QueryList::get($sourceUrl);

                  $ql->find('.view-content .post-item-desc a:nth-child(2)')->attrs('href')->map(function ($item) use ($sourceBaseUrl, $bagUrls) {
                        $bagUrls->push($sourceBaseUrl . $item);
                  });
            }

            $bagUrls->filter(function ($url) {
                  return preg_match('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', $url);
            })->each(function ($url) use ($bagPosts, $pageId) {
                  $ql = QueryList::get($url);

                  $img = $ql->find('.post-image img')->attr('data-echo');
                  $title = $ql->find('h2.display-6')->text();
                  $description = $ql->find('h3.display-8')->text();
                  $bodyHtml = $ql->find('.post-item-wrap')->html();
                  $body = (new EditorJsService)->outputToJson($bodyHtml);
                  
                  preg_match('/\d{2}\/\d{2}\/\d{4}/', $ql->find('h4.alt-font.small')->text(), $output_created_at);
                  $created_at = Carbon::createFromFormat('d/m/Y', trim(head($output_created_at)));

                  $data = [
                        'title' => $title,
                        'description' => $description,
                        'body' => $body,
                        'published_at' => $created_at,
                        'source' => 'Agência Brasil',
                        'publish' => 1,
                        'user_id' => 1,
                        'page_id' => $pageId,
                        'cover_inside' => 1,
                        'img' => $img,
                  ];

                  $bagPosts->push($data);
            });

            return $bagPosts;
      }
}
