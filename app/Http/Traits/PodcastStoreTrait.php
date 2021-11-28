<?php

namespace App\Http\Traits;

use App\Models\Podcast;

trait PodcastParserTrait
{
    /**
     * Insert extracted podcast data and their respective episodes into DB.
     *
     * @param  array  $podcastData
     * @return array|boolean
     */
    public function create(array $podcastData)
    {
        $podcast = $podcastData['podcast'];
        $episodes = $podcastData['podcast'];

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
    }

    /**
     * Store podcast episodes.
     *
     * @param Podcast $podcast
     * @param array $episodes;
     * @return array|boolean
     */
    public function createEpisode($podcast, $episodes)
    {
        $podcast->episodes()->saveMany($episodes);
    }
}
