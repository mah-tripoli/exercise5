<?php

namespace Tests\Feature\Api\Admin\Books;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UpdateBookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_update_book(): void
    {
        $book = Book::factory()->create();

        $title = $this->faker->sentence;

        $response = $this->actingAs($this->admin)->putJson('/api/admin/books/' . $book->id, [
            'title' => $title,
            'author' => $this->faker->name,
            'isbn' => $this->faker->isbn13(),
            'publish_year' => $this->faker->year,
            'genre_id' => Genre::inRandomOrder()->first()->id,
            'available_quantity' => random_int(1, 10),
            'description' => $this->faker->sentence,
            //'cover' => UploadedFile::fake()->image('book.jpg')
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => $title,
        ]);
    }

}
