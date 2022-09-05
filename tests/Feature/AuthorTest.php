<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    
    /**
     * This test is for evaluate the get authors list in book's form, 
     *
     * @return void
     */
    public function test_autocomplete_author()
    {
        $response = $this->get('/api/authors/autocomplete?term=a');

        $response->assertStatus(200);
    }

    /**
     * This test is for evaluate the get authors list in book's form, whitout term param (is mandatory), must throught 404
     *
     * @return void
     */
    public function test_autocomplete_fail_author()
    {
        $response = $this->get('/api/authors/autocomplete');

        $response->assertStatus(404);
    }
}
