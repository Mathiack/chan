<?php
namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Post;
use Tests\TestCase;

class PostTests extends TestCase
{
    use RefreshDatabase;

    public function test_list_zero_posts(): void
    {
        $response = $this->get('/api/posts');

        $response->assertStatus(200);
        $response->assertExactJson([]);
        // $response->assertJsonCount(0);
    }

    public function test_create_post(): void
    {
        $requestBody = [
            'content' => '!tchau mundo',
        ];

        $response = $this->post('/api/posts', $requestBody);

        $response->assertStatus(201);

        $responseBody = $response->json();
        $this->assertIsInt($responseBody['id']);
        $this->assertLessThanOrEqual(32, strlen($responseBody['id']));
        $this->assertLessThan(255, strlen($responseBody['image']));

        $response->assertSimilarJson([
            'id'         => $responseBody['id'],
            'content'    => $requestBody['content'],
            'created_at' => $responseBody['created_at'],
            'updated_at' => $responseBody['updated_at'],
        ]);

        $response = $this->get("/api/posts/{$responseBody['id']}");
        $response->assertStatus(200);
        $response->assertExactJson([
            'id'         => $responseBody['id'],
            'username'   => 'anon',
            'content'    => $requestBody['content'],
            'image'      => null,
            'created_at' => $responseBody['created_at'],
            'updated_at' => $responseBody['updated_at'],
        ]);
    }

    /*
    public function test_update_single_post(): void
    {
        $post = Post::factory()->create();

        $post = [
            'content' => 'Post de feito por Felipe Eduardo Monari!',
        ];

        $response = $this->put("/api/posts/{$post->id}", $requestBody);

        $response->assertStatus(200);
        $response->assertExactJson([
            'id'         => $post->id,
            'username'   => 'anon',
            'content'    => $requestBody['content'],
            'image'      => null,
            'created_at' => $post->created_at,
            'updated_at' => now(),
        ]);
    }
    */

    public  function test_display_one_post(): void {
        $post = Post::factory()->create();

        $response = $this->get('/api/posts/{$post->id}');
        $response->assertStatus(200);
        $response->assertJson($post->toArray());
    }

    public function test_display_wrong_post(): void {
        $this->test_display_one_post();

        $response = $this->get('/api/posts/olamundozilho');
        $response->assertStatus(404);

    }

    public function test_list_n_posts(): void {
        $post = Post::factory(10)->create();

        $response = $this->get('/api/posts');
        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    public function test_create_post_through_api(): void {
        $requestBody = [
            'content' => "olamundo",
        ];

        $response = $this->post('/api/posts', $requestBody);
        $response->assertStatus(201);

        $responseBody = $response->json();
        $this->assertIsInt($responseBody['id']);
        $response->assertSimilarJson([
            'id' => $responseBody['id'],
            'content' => $requestBody['content'],
            'created_at' => $responseBody['created_at'],
            'updated_at' => $responseBody['updated_at'],
        ]);
    }
}
