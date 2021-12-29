<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{

      public function run()
      {
            DB::disableQueryLog();

            $this->command->info('Inserindo comentários...');

            factory(App\Comment::class, 50)->create();
      }

}
