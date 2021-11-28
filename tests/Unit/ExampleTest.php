<?php

namespace Tests\Unit;

use App\Http\Traits\PodcastParserTrait;
use App\Http\Traits\PodcastStoreTrait;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use PodcastParserTrait, PodcastStoreTrait;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
}
