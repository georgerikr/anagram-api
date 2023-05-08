<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;


class AlgorithmTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    public function test_algorithm_returns_a_successful_response()
    {
        // Check if wordbase is loaded before running test, if it isn't, skip the test
        $count = DB::table('words')->count();
        if ($count < 1) {
            $this->markTestSkipped('The wordbase is not loaded, cannot proceed with test');
        }
        // Test positive case where input word has anagrams
        $response = $this->postJson('/input', ['data' => 'kare']);
        $response->assertStatus(200);
        $response->assertJson(['Anagrams of the word: erak, kaer, kera, krae, rake']);
        // Test negative case where the input word has no anagrams
        $response = $this->postJson('/input', ['data' => 'xyz']);
        $response->assertStatus(200);
        $response->assertJson(['No anagrams for given word']);
        // Test case where input is empty
        $response = $this->postJson('/input', ['data' => '']);
        $response->assertStatus(200);
        $response->assertJson(['Form is empty, enter a word']);
    }
}
