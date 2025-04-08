<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Like;


class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/database.json'));
        $data = json_decode($json, true);

        foreach ($data['data']['Likes'] as $entry) {
            Like::create($entry);
        }
    }
}
