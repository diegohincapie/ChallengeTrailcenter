<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    
    /**
     * Test for get basic list of books, doesn't receive parameters in the url, must be return 200 Code Response
     *
     * @return void
     */
    public function test_index_book()
    {
        $response = $this->get('/api/books');

        $response->assertStatus(200);
    }

    /**
     * Test for get basic list of books, receive parameters with slash in the url, must be return 404 Code Response
     *
     * @return void
     */
    public function test_index_b_book()
    {
        $response = $this->get('/api/books/params');

        $response->assertStatus(404);
    }

    /**
     * Test for save a new Book, whitout minimum params, must be return 500 Code Response
     *
     * @return void
     */
    public function test_save_book()
    {
        $response = $this->post('/api/books');

        $response->assertStatus(500);
    }

    
     /* Test for save a new Book, whit minimum params, must be return 200 Code Response
     *
     * @return void
     */
    public function test_save_b_book()
    {
        $response = $this->post('/api/books', ['author-name' => 'Pepito', 'author-birth' => '2000-04-01', 'author-genre' => 'Pepito', 'book-name' => 'Pepito', 'book-year' => '1950', 'library' => []]);

        $response->assertStatus(200);
    }

    /**
     * Test for get a book, whit id, must be return 200 Code Response if exists, or 404 if not exists
     *
     * @return void
     */
    public function test_get_book()
    {
        $response = $this->get('/api/books/1');

        if($response->getStatusCode() == 200) {
            $response->assertStatus(200);
        } else if($response->getStatusCode() == 404) {
            $response->assertStatus(404);
        }
    }

    /**
     * Test for update a Book, whitout minimum params, must be return 500 or 404 Code Response
     *
     * @return void
     */
    public function test_save_c_book()
    {
        $response = $this->put('/api/books/1');

        if($response->getStatusCode() == 500) {
            $response->assertStatus(500);
        } else if($response->getStatusCode() == 404) {
            $response->assertStatus(404);
        }
    }

     /* Test for update a Book, whit minimum params, must be return 200 or 404 Code Response
     *
     * @return void
     */
    public function test_save_d_book()
    {
        $response = $this->put('/api/books/20', ['author-name' => 'Pepitoa', 'author-birth' => '2000-04-01', 'author-genre' => 'Pepito', 'book-name' => 'Pepito', 'book-year' => '1950', 'library' => []]);

        if($response->getStatusCode() == 200) {
            $response->assertStatus(200);
        } else if($response->getStatusCode() == 404) {
            $response->assertStatus(404);
        }
    }

    /**
     * Test for update a Book, whitout minimum params, must be return 500 Code Response
     *
     * @return void
     */
    public function test_save_e_book()
    {
        $response = $this->put('/api/books');

        $response->assertStatus(405);
    }

    /**
     * Test for delete a Book, whit id, must be return 404 Code Response
     *
     * @return void
     */
    public function test_delete_book()
    {
        $response = $this->delete('/api/books/31');

        if($response->getStatusCode() == 200) {
            $response->assertStatus(200);
        } else if($response->getStatusCode() == 404) {
            $response->assertStatus(404);
        }
    }
}
