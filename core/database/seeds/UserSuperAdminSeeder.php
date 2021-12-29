<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSuperAdminSeeder extends Seeder
{
      public function run()
      {
            DB::disableQueryLog();

            DB::table('users')->delete();
            DB::unprepared("ALTER TABLE users AUTO_INCREMENT = 1;");

            $this->command->info('Inserindo Super Admin...');

            \App\User::create([
                  'name' => 'Denisbeder',
                  'username' => 'denisbeder',
                  'email' => 'denisbeder@gmail.com',
                  'password' => 'ddc010',
                  'admin' => -1,
                  'publish' => 1,
            ]);
      }
}
