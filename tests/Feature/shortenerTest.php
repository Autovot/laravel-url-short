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
    public function throw_error_when_url_provaided_are_incorrect_url(): void
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
    public function throw_error_when_url_provaided_are_void(): void
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
    public function throw_error_when_no_url_provaided_in_post(): void
    {
        $response = $this->postJson('/api/shortener');

        $response->assertStatus(200)->assertJsonFragment([
            'status' => 'incorrect',
        ]);
    }


    /**
     * @test
     */
    // public function use_url_shortened_and_check_redirect(): void
    // {
    //     $urlInput = 'https://www.google.es/';
    //     $urlOutput = md5($urlInput);

    //     $this->postJson('/api/shortener', ['url-input' => $urlInput]);

    //     $urlSmashed = Url::where('smashed', $urlOutput)->first()->value('smashed');

    //     $response = $this
    //         ->followingRedirects()
    //         ->get('/', ['smashed' => $urlSmashed])
    //         ->assertStatus(302); // TODO no es correcto del todo, hacer que devuelva 302
    // }

    /**
     * @test
     */
    // public function throw_error_when_redirect_id_provaided_are_incorrect(): void
    // {
    //     $urlTest = 'test';

    //     $response = $this
    //         ->followingRedirects()
    //         ->get('/', ['smashed' => $urlTest])
    //         ->assertStatus(404); // TODO hacer que esto devuelva 404
    // }

    //test que devuelva todos los datos necesarios
    /**
     * @test
     */
    public function get_all_data_of_url_table_json_format_and_parse(): void
    {
        $urlInput = 'https://www.google.es/';
        $urlOutput = md5($urlInput);

        $urlResponse = $this->postJson('/api/shortener', ['url-input' => $urlInput]);

        $dataResponse = $this->getJson('/tdash');
        $dataResponse->assertStatus(200)->assertJsonFragment([
            // 'id' => 1,
            'origin' => $urlInput,
            'smashed' => $urlOutput,
            'used' => 0
        ]);
    }

}
