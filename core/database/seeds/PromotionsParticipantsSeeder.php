<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromotionsParticipantsSeeder extends Seeder
{

      public function run()
      {
            DB::disableQueryLog();

            $this->command->info('Inserindo participantes...');

            factory(App\PromotionParticipant::class, 100)->create();
      }

}
