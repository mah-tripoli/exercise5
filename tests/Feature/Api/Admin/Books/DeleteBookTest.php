<?php

namespace Tests\Feature\Api\Admin\Books;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_a_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->actingAs($this->admin)->deleteJson('/api/admin/books/' . $book->id);

        $response->assertNoContent();

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

}
