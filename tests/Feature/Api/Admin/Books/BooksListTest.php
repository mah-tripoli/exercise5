<?php

namespace Tests\Feature\Api\Admin\Books;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BooksListTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_returns_a_list_of_books(): void
    {
        Book::factory(10)->create();

        $response = $this->actingAs($this->admin)->getJson('/api/admin/books');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [['id', 'title', 'author', 'isbn', 'publish_year', 'genre_id', 'available_quantity', 'description', 'file', 'coverUrl']],
            'links',
            'meta'
        ]);
    }

}
