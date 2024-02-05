<?php

namespace Tests\Feature\Api\Admin\Books;

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateBookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_create_book(): void
    {

        Storage::fake('public');

        $title = $this->faker->sentence;
        $response = $this->actingAs($this->admin)->postJson('/api/admin/books', [
            'title' => $title,
            'author' => $this->faker->name,
            'isbn' => $this->faker->isbn13(),
            'publish_year' => $this->faker->year,
            'genre_id' => Genre::inRandomOrder()->first()->id,
            'available_quantity' => random_int(1, 10),
            'description' => $this->faker->sentence,
            'cover' => UploadedFile::fake()->image('book.jpg')
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('books', [
            'title' => $title,
        ]);
    }
}
