<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;


class ShortenerTest extends TestCase
{
    // Reset database
    use RefreshDatabase;

    public function test_database_migration(): void
    {
        Artisan::call('migrate:fresh');
        $this->assertTrue(Schema::hasTable('url'));
    }

    // /**
    //  * Endpoint /shortener de tipo post que recibe una url
    //  * y devuelve una url acortada.
    //  */
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

    // public function test_shortener_db_entry_created(): void
    // {
    //     $this->assertDatabaseCount('url', 1);
    // }

    // public function test_short_url(): void
    // {
    //     $urlInput = 'https://www.google.es/';
    //     $urlOutput = md5($urlInput);

    //     $response = $this->get('/url/' . $urlOutput);
    //     $response->assertStatus(200);
    //     $response->assertPathIs($urlInput);
    // }
}
