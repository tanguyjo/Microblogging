<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $user = User::factory()->create([
            'username' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->username);
        $this->assertEquals('john@example.com', $user->email);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create([
            'username' => 'Initial Name'
        ]);
        
        $user->username = 'Jane Doe';
        $user->save();

        $this->assertEquals('Jane Doe', $user->fresh()->username);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();
        $userId = $user->id;

        $user->delete();

        $this->assertNull(User::find($userId));
        $this->assertDatabaseMissing('users', ['id' => $userId]);
    }
}