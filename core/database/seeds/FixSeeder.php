<?php

use App\Menu;
use App\Post;
use App\Destination;
use App\Events\ViewsEvent;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class FixSeeder extends Seeder
{
    protected $destinations = [
        [
            'title' => 'Brasil', 
            'children' => [
                [
                    'title' => 'Centro Oeste', 
                    'children' => [
                        [
                            'title' => 'Mato Grosso do Sul', 
                            'children' => [
                                ['title' => 'Bonito'],
                                ['title' => 'Bodoquena'],
                                ['title' => 'Jardim'],
                                ['title' => 'Pantanal'],
                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Nordeste', 
                    'children' => [
                        ['title' => 'Natal'],
                        ['title' => 'São Miguel dos Milagres'],
                        ['title' => 'Maragogi'],
                        ['title' => 'Porto de Galinhas'],
                    ]
                ]
            ]
        ],
        [
            'title' => 'América do Norte',
            'children' => [
                ['title' => 'Canadá'],
                ['title' => 'Nova Iorque'],
                ['title' => 'São Francisco'],
            ]
        ],
        [
            'title' => 'Europa',
            'children' => [
                ['title' => 'Paris'],
                ['title' => 'Moscou'],
                ['title' => 'Amsterdã'],
            ]
        ]
    ];

    public function run()
    {        
        $treeDestinations = $this->makeDestinations($this->destinations);
        $destinations = Destination::all();  
        $posts = Post::all();

        $this->command->info('Criando Menus...');
        DB::table('menus')->delete();
        DB::unprepared("ALTER TABLE menus AUTO_INCREMENT = 1;");
        Menu::create(['header' => [
            [
                'title' => 'Home',
                'type' => 'static',
                'url' => '/',
            ],    
            [
                'title' => 'Promoções',
                'type' => 'static',
                'url' => '/promocoes',
            ],       
            [
                'title' => 'Notícias',
                'type' => 'dinamic',
                'page' => 1,
                'submenu' => 'page_categories',
            ],
            [
                'title' => 'Guia de Destinos',
                'type' => 'static',
                'url' => '/destinos',
            ], 
            [
                'title' => 'Hotéis',
                'type' => 'static',
                'url' => '/hoteis',
            ], 
            [
                'title' => 'Passagens Aéreas',
                'type' => 'static',
                'url' => '/passagens-aereas',
            ], 
            [
                'title' => 'Contato',
                'type' => 'static',
                'url' => '/contato',
            ], 
        ]]);
        
        $this->command->info('Criando Destinos...');
        DB::table('destinations')->delete();
        DB::unprepared("ALTER TABLE destinations AUTO_INCREMENT = 1;");
        foreach ($treeDestinations as $tree) {
            Destination::create($tree);
        }
        
        $this->command->info('Sincronizando Posts ao Destino...');
        foreach ($posts as $post) {
            $post->destinations()->sync([]);
            $post->destinations()->sync([$destinations->shuffle()->first()->id]);
        }

        $this->command->info('Criando Views...');
        for ($i = 0; $i < 200; $i++) {
            $this->command->info('Inserindo View: ' . $i . '/200');
            event(new ViewsEvent($destinations->shuffle()->first()));
        }

        Artisan::call('cache:clear');
    }

    public function makeDestinations(array $item)
    {
        return array_map(function ($value) {
            $newItem = [];
            $newItem['title'] = $value['title'];
            $newItem['slug'] = Str::slug($value['title']);
            $newItem['user_id'] = 1;
            $newItem['publish'] = 1;
            if (isset($value['children']) ) {
                $newItem['children'] = $this->makeDestinations($value['children']);
            }
            return $newItem;
        }, $item);
    }
}
