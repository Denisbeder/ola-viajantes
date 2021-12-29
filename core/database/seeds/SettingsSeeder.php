<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
      public function run()
      {
            DB::disableQueryLog();

            DB::table('settings')->delete();
            DB::unprepared("ALTER TABLE settings AUTO_INCREMENT = 1;");

            $this->command->info('Inserindo Configurações...');

            \App\Setting::create([
                  'data' => []
            ]);
      }
}
