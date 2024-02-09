<?php

namespace Tests\Feature;

use Tests\TestCase;

class ShortenerTest extends TestCase
{
    /**
     * Endpoint /shortener de tipo post que recibe una url
     * y devuelve una url acortada.
     */
    public function test_shortener_api(): void
    {

        $urlInput = 'https://www.google.es/';
        $response = $this->postJson('/api/shortener', ['url-input' => $urlInput]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'url-input' => $urlInput
            ]);
    }

    public function test_short_url(): void
    {

    }

    public function test_short_url_get_data()
    {

    }
}
