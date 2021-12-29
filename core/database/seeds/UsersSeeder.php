<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{

      public function run()
      {
            DB::disableQueryLog();

            $this->command->info('Inserindo usuários...');

            factory(App\User::class, 50)->create();
      }

}
