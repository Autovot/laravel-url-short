<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\TestResponse;
use App\Models\Url;
use Tests\TestCase;


class ShortenerTest extends TestCase
{
    // Reset database
    use RefreshDatabase;

    // /**
    //  * Endpoint /shortener de tipo post que recibe una url
    //  * y devuelve una url acortada.
    //  */

    /**
     * @test
     */
    public function when_url_provaided_are_correct_and_saved_in_db(): void
    {
        $urlInput = 'https://www.google.es/';
        $urlOutput = md5($urlInput);

        $response = $this->postJson('/api/shortener', ['url-input' => $urlInput]);

        $response->assertStatus(200)->assertJson([
            'status' => 'created',
            'smashed' => $urlOutput,
        ]);

        $this->assertDatabaseCount('url', 1);
    }

    /**
     * @test
     */
    public function trhow_error_when_url_provaided_are_incorrect_url(): void
    {
        $urlInput = 'tongo';

        $response = $this->postJson('/api/shortener', ['url-input' => $urlInput]);

        $response->assertStatus(200)->assertJsonFragment([
            'status' => 'incorrect',
        ]);
    }

    /**
     * @test
     */
    public function trhow_error_when_url_provaided_are_void(): void
    {
        $urlInput = '';

        $response = $this->postJson('/api/shortener', ['url-input' => $urlInput]);

        $response->assertStatus(200)->assertJsonFragment([
            'status' => 'incorrect',
        ]);
    }

    /**
     * @test
     */
    public function trhow_error_when_no_url_provaided_in_post(): void
    {
        $response = $this->postJson('/api/shortener');

        $response->assertStatus(200)->assertJsonFragment([
            'status' => 'incorrect',
        ]);
    }


    /**
     * @test
     */
    public function use_url_shortened_and_check_redirect(): void
    {
        $urlInput = 'https://www.google.es/';
        $urlOutput = md5($urlInput);

        $this->postJson('/api/shortener', ['url-input' => $urlInput]);

        $urlSmashed = Url::where('smashed', $urlOutput)->first()->value('smashed');

        // !FIXME No redirecciona por que no rula web.php
        $response = $this->get('/', ['smashed => $urlSmashed']);
        $response->assertStatus(200);
        var_dump($response->headers);
    }

    // test que pruebe que pasa si se le pasa una url incorrecta, se espera 404

    // test que pruebe que pasa si no se le pasa una url, se espera el index

    //test que devuelva todos los datos necesarios

}
