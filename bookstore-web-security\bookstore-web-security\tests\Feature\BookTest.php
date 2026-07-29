<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_book()
    {
        $response = $this->postJson('/api/books', [
            'title' => 'Sample Book',
            'author' => 'John Doe',
            'description' => 'This is a sample book description.',
            'price' => 19.99,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', [
            'title' => 'Sample Book',
            'author' => 'John Doe',
        ]);
    }

    /** @test */
    public function it_can_list_books()
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    /** @test */
    public function it_can_show_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson('/api/books/' . $book->id);

        $response->assertStatus(200);
        $this->assertEquals($book->title, $response->json('title'));
    }

    /** @test */
    public function it_can_update_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->putJson('/api/books/' . $book->id, [
            'title' => 'Updated Book Title',
            'author' => 'Jane Doe',
            'description' => 'Updated description.',
            'price' => 29.99,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Updated Book Title',
        ]);
    }

    /** @test */
    public function it_can_delete_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson('/api/books/' . $book->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);
    }
}