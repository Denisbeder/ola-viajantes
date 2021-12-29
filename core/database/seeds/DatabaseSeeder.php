<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CoutriesStatesCitiesSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(UserSuperAdminSeeder::class);
        //$this->call(UsersSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(CommentsSeeder::class);
        $this->call(PromotionsParticipantsSeeder::class);
    }
}
