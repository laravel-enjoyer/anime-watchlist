<?php

namespace App\Console\Commands;

use App\Services\AnimeUpdater;
use Illuminate\Console\Command;

class UpdateAnimeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'anime:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update anime db via api';

    public function __construct(protected AnimeUpdater $animeUpdater)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->animeUpdater->updateAnime();
    }
}
