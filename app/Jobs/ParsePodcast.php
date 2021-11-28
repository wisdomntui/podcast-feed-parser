<?php

namespace App\Jobs;

use App\Http\Traits\PodcastParserTrait;
use App\Http\Traits\PodcastStoreTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParsePodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, PodcastParserTrait, PodcastStoreTrait;

    protected $rssFeed;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $rssFeed)
    {
        $this->rssFeed = $rssFeed;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Extract podcast data
        $data = $this->extract($this->rssFeed);

        // Store podcast data
        $this->create($data);
    }
}
