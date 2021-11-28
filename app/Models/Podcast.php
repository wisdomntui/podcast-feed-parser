<?php

namespace App\Models;

use App\Models\PodcastEpisode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'artwork_url',
        'rss_feed_url',
        'description',
        'language',
        'website_url',
    ];

    /**
     * The podcast's episode.
     */
    public function episodes()
    {
        return $this->hasMany(PodcastEpisode::class);
    }
}
