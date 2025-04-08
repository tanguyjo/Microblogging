<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Hashtag;

class HashtagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/database.json'));
        $data = json_decode($json, true);

        foreach ($data['data']['Hashtags'] as $entry) {
            Hashtag::create($entry);
        }
    }
}
