<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    /** @use HasFactory<\Database\Factories\HashtagFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'created_at',
        'updated_at'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_hashtag')->withTimestamps();
    }
}

