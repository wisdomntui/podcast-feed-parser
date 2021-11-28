<?php

namespace Tests\Unit;

use App\Http\Traits\PodcastParserTrait;
use App\Http\Traits\PodcastStoreTrait;
use Tests\TestCase;

class PodcastParseStoreTest extends TestCase
{
    use PodcastParserTrait, PodcastStoreTrait;

    /**
     * Test that podcast feed caan be parsed.
     *
     * @return array $extractedData
     */
    public function test_it_can_parse_podcast_feed()
    {
        // eXTRACT PODCAST DATA
        $extractedData = $this->extract('https://www.omnycontent.com/d/playlist/2b465d4a-14ee-4fbe-a3c2-ac46009a2d5a/b1907157-de93-4ea2-a952-ac700085150f/be1924e3-559d-4f7d-98e5-ac7000851521/podcast.rss');

        $this->assertIsArray($extractedData);

        return $extractedData;
    }

    /**
     * Test that podcast feed data can be stored.
     *
     * @return array $extractedData
     * @depends test_it_can_parse_podcast_feed
     */
    public function test_it_can_save_podcast_feed_data($extractedData)
    {
        // Store podcast data
        $res = $this->create($extractedData);

        $this->assertTrue($res);
    }
}
