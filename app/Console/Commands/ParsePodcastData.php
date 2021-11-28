<?php

namespace App\Console\Commands;

use App\Jobs\ParsePodcast;
use Illuminate\Console\Command;

class ParsePodcastData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:podcast-data {rssFeed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse and store podcast feed data into database.';

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
     * @return int
     */
    public function handle()
    {
        // Get RSS Feed from command
        $rssFeed = $this->argument('rssFeed');

        // Dispatch job to parse and store podcast data in the background.
        ParsePodcast::dispatch($rssFeed)
            ->delay(now()->addMinutes(1));
        return Command::SUCCESS;
    }
}
