<?php

namespace App\Console\Commands;

use App\Supports\Services\PurgeNginxCacheService;
use Illuminate\Console\Command;

class PurgeNginxCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nginx:purge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean all Nginx cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        (new PurgeNginxCacheService)->purgeAll();

        $this->info('Nginx cache cleared!');
    }
}
