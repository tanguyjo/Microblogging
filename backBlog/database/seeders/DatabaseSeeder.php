<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        UsersTableSeeder::class,
        PostsTableSeeder::class,
        FollowsTableSeeder::class,
        CommentsTableSeeder::class,
        LikesTableSeeder::class,
        HashtagsTableSeeder::class,
        PostHashtagTableSeeder::class,
    ]);
}
}
