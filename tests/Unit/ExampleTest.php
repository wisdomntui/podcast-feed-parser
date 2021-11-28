<?php

namespace Tests\Unit;

use App\Http\Traits\PodcastParserTrait;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use PodcastParserTrait;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $data = $this->extract('https://www.omnycontent.com/d/playlist/2b465d4a-14ee-4fbe-a3c2-ac46009a2d5a/b1907157-de93-4ea2-a952-ac700085150f/be1924e3-559d-4f7d-98e5-ac7000851521/podcast.rss');

        dd($data);
    }
}
