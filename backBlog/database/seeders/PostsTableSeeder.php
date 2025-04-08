<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/database.json'));
        $data = json_decode($json, true);

        foreach ($data['data']['Posts'] as $post) {
            Post::create($post);
        }
    }
}
