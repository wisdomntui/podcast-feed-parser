<?php

namespace App\Http\Traits;

use App\Models\Podcast;

trait PodcastStoreTrait
{
    /**
     * Insert extracted podcast data and their respective episodes into DB.
     *
     * @param  array  $podcastData
     * @return boolean
     */
    public function create(array $podcastData)
    {
        try {
            $podcast = $podcastData['podcast'];
            $episodes = $podcastData['episodes'];

            // Create podcast
            $newPodcast = new Podcast();
            $newPodcast->title = $podcast->title;
            $newPodcast->artwork_url = $podcast->artwork_url;
            $newPodcast->rss_feed_url = $podcast->rss_url;
            $newPodcast->description = $podcast->description;
            $newPodcast->language = $podcast->website_url;
            $newPodcast->website_url = $podcast->website_url;

            // Save episode if podcast is created
            if ($newPodcast->save()) {
                $this->createEpisode($newPodcast, $episodes);
            }

            return true;
        } catch (\Throwable $th) {
            logger($th);
            return false;
        }
    }

    /**
     * Store podcast episodes.
     *
     * @param Podcast $podcast
     * @param array $episodes;
     * @return void
     */
    public function createEpisode($podcast, $episodes)
    {
        $podcast->episodes()->saveMany($episodes);
    }
}
