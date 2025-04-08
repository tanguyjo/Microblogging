<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Follow;
use Illuminate\Support\Facades\File;

class FollowsTableSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('seeders/data/database.json'));
        $data = json_decode($json, true);

        foreach ($data['data']['Follows'] as $entry) {
            Follow::create($entry);
        }
    }
}
