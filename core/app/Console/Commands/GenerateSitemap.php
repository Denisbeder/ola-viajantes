<?php

namespace App\Console\Commands;

use App\Supports\Services\GenerateSitemapService;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        (new GenerateSitemapService)->handle();
    }
}
