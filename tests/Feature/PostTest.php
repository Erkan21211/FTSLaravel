<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_index_page_displays_posts()
    {
        // Arrange
        $user = User::factory()->create();
        $posts = Post::factory()->count(3)->create(['user_id' => $user->id]);

        // Act
        $response = $this->actingAs($user)->get(route('posts.index'));

        // Assert
        $response->assertStatus(200);
        $response->assertSee($posts->first()->title); // Ensure the page contains the title of a post
    }

    public function test_store_creates_post()
    {
        // Arrange
        $user = User::factory()->create();
        $postData = [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
        ];

        // Act
        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        // Assert
        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'user_id' => $user->id,
        ]);
    }

    public function test_edit_page_displays_post_data()
    {
        // Arrange
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Act
        $response = $this->actingAs($user)->get(route('posts.edit', $post->id));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('posts.edit');
        $response->assertViewHas('post', $post);
    }

    public function test_update_updates_post()
    {
        // Arrange
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ];

        // Act
        $response = $this->actingAs($user)->put(route('posts.update', $post->id), $updatedData);

        // Assert
        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);
    }

    public function test_destroy_deletes_post()
    {
        // Arrange
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Act
        $response = $this->actingAs($user)->delete(route('posts.destroy', $post->id));

        // Assert
        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

    public function test_user_cannot_edit_another_users_post()
    {
        // Arrange
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user2->id]);

        // Act
        $response = $this->actingAs($user1)->get(route('posts.edit', $post->id));

        // Assert
        $response->assertStatus(403); // Forbidden
    }
}
