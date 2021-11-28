<?php

namespace App\Http\Traits;

use App\Models\PodcastEpisode;
use stdClass;

trait PodcastParserTrait
{
    /**
     * Entry function for extracting podcast feed data.
     * Returns array on success and boolean on failure (Error is logged to console)
     *
     * @param  string  $feedUrl
     * @return array|boolean
     */
    public function extract($feedUrl)
    {
        try {
            $xml = simplexml_load_file($feedUrl);

            // Check if RSS Feed is valid
            if ($xml !== false) {

                $namespaces = $xml->getNamespaces(true);

                // Register XML namespaces
                foreach ($namespaces as $key => $value) {
                    $xml->registerXPathNamespace($key, $value);
                }

                // Podcast Data
                $podcast = $this->getPodcastData($xml);

                // Episodes Data
                $episodes = $this->getEpisodeData($xml);
            } else {
                logger("Feed does not exist.");
                return false;
            }

            return compact('podcast', 'episodes');
        } catch (\Throwable $th) {
            logger($th);
            return false;
        }
    }

    /**
     * Get data for podcast.
     *
     * @param  mixed  $xml
     * @return array
     */
    public function getPodcastData($xml)
    {
        $podcast = new stdClass();

        // Write check for null values
        $podcast->title = $this->getPodcastField($xml, '//channel/title');
        $podcast->description = $this->getPodcastField($xml, '//channel/description');
        $podcast->language = $this->getPodcastField($xml, '//channel/language');
        $podcast->website_url = $this->getPodcastField($xml, '//channel/link');

        // Get artwork url
        $podcast->artwork_url = null;
        if ($this->getPodcastField($xml, '//channel/image', true)) {
            foreach ($this->getPodcastField($xml, '//channel/image', true) as $image) {
                if ($image->url) {
                    $podcast->artwork_url = $image->url->__toString();
                }
            }
        }

        // Get rss url
        $podcast->rss_url = null;
        if ($this->getPodcastField($xml, '//channel/atom:link', true)) {
            foreach ($this->getPodcastField($xml, '//channel/atom:link', true) as $link) {
                if ($link->attributes() && $link->attributes()->rel->__toString() == 'self') {
                    $podcast->rss_url = $link->attributes()->href->__toString();
                }
            }
        }

        return $podcast;
    }

    /**
     * Get data for podcast episodes.
     *
     * @param  mixed  $xml
     * @return array
     */
    public function getEpisodeData($xml)
    {
        $episodes = [];

        // Loop through the item tags which represent episodes and get the needed data.
        foreach ($xml->xpath('//channel/item') as $item) {
            $episode = new PodcastEpisode();
            // Write check for null values
            $episode->title = $this->getEpisodeField($item, 'title');
            $episode->description = $this->getEpisodeField($item, 'description');
            $episode->audio_url = $item->enclosure->attributes()->url->__toString();
            $episode->episode_url = $this->getEpisodeField($item, 'link');

            $episodes[] = $episode;
        }

        return $episodes;
    }

    /**
     * Prepares and returns data for podcast fields based on an XPath path that represents XML element hierachy.
     *
     * @param mixed $xml
     * @param  mixed  $path
     * @return mixed
     */
    public function getPodcastField($xml, $path, $url = false)
    {
        if ($url) {
            return $xml->xpath($path) ? $xml->xpath($path) ?? null : null;
        } else {
            return $xml->xpath($path) ? ($xml->xpath($path)[0])->__toString() ?? null : null;
        }
    }

    /**
     * Prepares and returns data for episode fields.
     *
     * @param mixed $item
     * @param string $field
     * @return mixed
     */
    public function getEpisodeField($item, $field)
    {
        return $item->$field ? $item->$field->__toString() : null;
    }
}
