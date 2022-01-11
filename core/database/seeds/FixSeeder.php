<?php

use App\Post;
use App\Destination;
use App\Events\ViewsEvent;
use Illuminate\Database\Seeder;

class FixSeeder extends Seeder
{

    public function run()
    {
        $this->command->info('Corrigindo Items...');
     
        $destinations = Destination::all();  
        $posts = Post::all();
        
        foreach ($posts as $post) {
            $post->destinations()->sync([]);
            $post->destinations()->sync([$destinations->shuffle()->first()->id]);
        }

        for ($i = 0; $i < 200; $i++) {
            $this->command->info('Inserindo View: ' . $i . '/200');
            event(new ViewsEvent($destinations->shuffle()->first()));
        }
    }
}
