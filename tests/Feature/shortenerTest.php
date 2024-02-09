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
    public function test_shortener_api(): bool
    {
        $urlInput = 'https://www.google.es/';

        $urlOutputTest = 'https://localhost/url/' . md5($urlInput);

        $response = $this->postJson('/api/shortener', ['url-input' => $urlInput]);

        $urlOutputApi = 'https://localhost/url/' . $response->json()['smashed'];

        $result = $urlOutputTest == $urlOutputApi;
        var_dump($result);
        return $result;
    }

    // public function test_short_url(): void
    // {

    // }

    // public function test_short_url_get_data()
    // {

    // }
}
