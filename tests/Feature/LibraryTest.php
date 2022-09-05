<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LibraryTest extends TestCase
{
    
    /**
     * Test for get basic list of libraries, doesn't receive parameters in the url, must be return 200 Code Response
     *
     * @return void
     */
    public function test_index_library()
    {
        $response = $this->get('/api/libraries');

        $response->assertStatus(200);
    }

    /**
     * Test for get basic list of libraries, receive book param (must be an integer), must be return 200 Code Response
     *
     * @return void
     */
    public function test_index_b_library()
    {
        $response = $this->get('/api/libraries?book=1');

        $response->assertStatus(200);
    }

    /**
     * Test for get basic list of libraries, receive book param (not an integer), must be return 500 Code Response
     *
     * @return void
     */
    public function test_index_c_library()
    {
        $response = $this->get('/api/libraries?book=a');

        $response->assertStatus(500);
    }

    /**
     * Test for get basic list of libraries, receive parameters with slash in the url, must be return 404 Code Response
     *
     * @return void
     */
    public function test_index_d_library()
    {
        $response = $this->get('/api/libraries/params');

        $response->assertStatus(404);
    }

    /**
     * This test is for evaluate the get libraries list in book's form, 
     *
     * @return void
     */
    public function test_autocomplete_libraries()
    {
        $response = $this->get('/api/libraries/autocomplete?term=a');

        $response->assertStatus(200);
    }

    /**
     * This test is for evaluate the get authors list in book's form, whitout term param (is mandatory), must throught 404
     *
     * @return void
     */
    public function test_autocomplete_fail_libraries()
    {
        $response = $this->get('/api/libraries/autocomplete');

        $response->assertStatus(404);
    }

    /**
     * Test for save a new Library, whitout minimum params, must be return 500 Code Response
     *
     * @return void
     */
    public function test_save_library()
    {
        $response = $this->post('/api/libraries');

        $response->assertStatus(500);
    }

    
     /* Test for save a new Library, whit minimum params, must be return 200 Code Response
     *
     * @return void
     */
    public function test_save_b_library()
    {
        $response = $this->post('/api/libraries', ['name' => 'Pepito', 'address' => 'Mi casa']);

        $response->assertStatus(200);
    }
}
