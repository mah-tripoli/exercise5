<?php

namespace Tests\Feature\Books;

use App\Models\Book;
use App\Models\Rental;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RentBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_books_can_be_rented(): void
    {

        $books = Book::factory(10)->create();
        $book = $books->random();

        $response = $this->actingAs($this->user)->followingRedirects()->post('/rent-book', [
            'book_id' => $book->id
        ]);

        $response->assertSee('Book rented successfully');
    }

    public function test_rented_book_can_not_be_rented(): void
    {

        $books = Book::factory(10)->create();
        $book = $books->random();
        Rental::factory()->create([
            'book_id' => $book->id,
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->followingRedirects()->post('/rent-book', [
            'book_id' => $book->id
        ]);

        $response->assertSee('Book is already rented');
    }

    public function test_can_not_rent_book_when_out_of_stock(): void
    {

        $books = Book::factory(10)->create();
        $book = $books->random();
        $book->available_quantity = 0;
        $book->save();

        $response = $this->actingAs($this->user)->followingRedirects()->post('/rent-book', [
            'book_id' => $book->id
        ]);

        $response->assertSee('Book is not available');
    }
}
