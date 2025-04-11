<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_encodes_a_valid_url()
    {
        $response = $this->postJson('/api/encode', [
            'original_url' => 'https://example.com'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['short_url'])
            ->assertJsonFragment(['short_url' => $response->json('short_url')]);
    }

    /** @test */
    public function it_fails_to_encode_invalid_url()
    {
        $response = $this->postJson('/api/encode', [
            'original_url' => 'invalid-url'
        ]);

        $response->assertStatus(422)
            ->assertJson(['error' => 'Invalid URL provided']);
    }

    /** @test */
    public function it_decodes_a_valid_short_url()
    {
        $originalUrl = 'https://example.com';
        $encodeResponse = $this->postJson('/api/encode', [
            'original_url' => $originalUrl
        ]);
        $shortUrl = $encodeResponse->json('short_url');

        $decodeResponse = $this->postJson('/api/decode', [
            'short_url' => $shortUrl
        ]);

        $decodeResponse->assertStatus(200)
            ->assertJson(['original_url' => $originalUrl]);
    }

    /** @test */
    public function it_fails_to_decode_invalid_format()
    {
        $response = $this->postJson('/api/decode', [
            'short_url' => 'not-a-url'
        ]);

        $response->assertStatus(422)
            ->assertJson(['error' => 'Invalid URL provided']);
    }

    /** @test */
    public function it_fails_to_decode_nonexistent_short_code()
    {
        $response = $this->postJson('/api/decode', [
            'short_url' => 'http://short.est/notfound'
        ]);

        $response->assertStatus(404)
            ->assertJson(['error' => 'Original URL not found']);
    }
}
