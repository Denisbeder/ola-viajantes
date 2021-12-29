<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
      public function run()
      {
            DB::disableQueryLog();

            DB::table('categories')->delete();
            DB::unprepared("ALTER TABLE categories AUTO_INCREMENT = 1;");

            $categories = [
                  'Geral',
                  'Política',
                  'Polícia',
                  'Estado',
                  'Cidade',
                  'Região',
                  'Mundo',
                  'Esporte',
                  'Agronegócios',
                  'Economia',
                  'Educação',
            ];

            $this->command->info('Inserindo categorias...');
            
            foreach ($categories as $category) {
                  $data =  ['slug' => Str::slug($category), 'title' => $category, 'publish' => 1, 'user_id' => 1];
                  \App\Category::create($data);
            }
      }
}
