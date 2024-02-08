<?php

namespace Tests\Feature;

use Tests\TestCase;

class shortenerTest extends TestCase
{
    /**
     * Endpoint /shortener de tipo post que recibe una url
     * y devuelve una url acortada.
     */
    public function test_shortener_api(): void
    {

        $urlInput = 'https://www.google.es/';
        $response = $this->postJson('/shortener', ['url-input' => $urlInput]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'url-output' => 'd3ba7b034c76b5b014da9398ffdebef0'
            ]);
    }

    public function test_short_url(): void
    {

    }

    public function test_short_url_get_data()
    {

    }
}
