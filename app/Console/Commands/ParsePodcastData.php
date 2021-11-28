<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ParsePodcastData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:podcast-data {feedLink}';

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
        return Command::SUCCESS;
    }
}
