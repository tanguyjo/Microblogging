<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_and_unlike_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $token = $user->createToken('test')->plainTextToken;

        // Like
        $likeResponse = $this->withHeader('Authorization', "Bearer $token")
                             ->postJson('/api/likes', ['post_id' => $post->id]);

        $likeResponse->assertCreated();
        $likeId = $likeResponse->json('id');

        // Unlike
        $unlikeResponse = $this->withHeader('Authorization', "Bearer $token")
                               ->deleteJson("/api/likes/{$likeId}");

        $unlikeResponse->assertNoContent();
    }
}