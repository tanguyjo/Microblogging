<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Comment;
use Illuminate\Support\Facades\File;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/database.json'));
        $data = json_decode($json, true);

        foreach ($data['data']['Comments'] as $entry) {
            Comment::create($entry);
        }
    }
}
