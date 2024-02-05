<?php

namespace Tests\Feature\Api\Admin\Books;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->actingAs($this->admin)->getJson('/api/admin/books/' . $book->id);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'author',
                'isbn',
                'publish_year',
                'genre_id',
                'available_quantity',
                'description',
                'file',
                'coverUrl'
            ]
        ]);
    }

}
