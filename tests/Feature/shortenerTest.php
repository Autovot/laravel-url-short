<?php

namespace Tests\Feature;

use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShortenerTest extends TestCase
{

    // Reset database
    use RefreshDatabase;

    /**
     * Endpoint /shortener de tipo post que recibe una url
     * y devuelve una url acortada.
     */
    public function test_shortener_api_correct(): void
    {
        $urlInput = 'https://www.google.es/';
        $urlOutput = md5($urlInput);

        $response = $this->postJson('/api/shortener', ['url-input' => $urlInput]);

        $response->assertStatus(200)->assertJson([
            'status' => 'created',
            'smashed' => $urlOutput,
        ]);
    }

    public function test_shortener_api_incorrect(): void
    {
        $urlInput = 'tongo';

        $response = $this->postJson('/api/shortener', ['url-input' => $urlInput]);

        $response->assertStatus(200)->assertJsonFragment([
            'status' => 'incorrect',
        ]);
    }

    public function test_shortener_api_void(): void
    {
        $urlInput = '';

        $response = $this->postJson('/api/shortener', ['url-input' => $urlInput]);

        $response->assertStatus(200)->assertJsonFragment([
            'status' => 'incorrect',
        ]);
    }

    public function test_shortener_api_notfound(): void
    {
        $response = $this->postJson('/api/shortener');

        $response->assertStatus(200)->assertJsonFragment([
            'status' => 'incorrect',
        ]);
    }

    // public function test_short_url(): void
    // {

    // }

    // public function test_short_url_get_data()
    // {

    // }
}
