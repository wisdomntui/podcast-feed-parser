<?php

namespace App\Models;

use App\Models\Podcast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodcastEpisode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'audio_url',
        'episode_url',
    ];

    /**
     * The episode's podcast.
     */
    public function podcast()
    {
        return $this->belongsTo(Podcast::class);
    }
}
