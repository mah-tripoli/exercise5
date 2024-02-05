<?php

namespace Tests\Feature\Books;

use App\Models\Book;
use App\Models\Rental;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BooksListTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_books_list(): void
    {
        $books = Book::factory(10)->create();

        // Pick a random book for assertion
        $book = $books->random();

        $response = $this->get('/books');

        $response->assertStatus(200);
        $response->assertSee($book->title);
    }

    public function test_rented_books_can_be_returned(): void
    {
        $books = Book::factory(10)->create();

        // Pick a random book for assertion
        $book = $books->random();

        Rental::factory()->create([
            'book_id' => $book->id,
            'user_id' => $this->user->id,
        ]);
        $response = $this->actingAs($this->user)->get('/books');

        $response->assertStatus(200);
        $response->assertSeeTextInOrder([
            $book->title,
            'Return book'
        ]);
    }
}
