<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostHashtag extends Model
{
    use HasFactory;

    protected $table = 'post_hashtag';

    protected $fillable = [
        'post_id',
        'hashtag_id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;
}
