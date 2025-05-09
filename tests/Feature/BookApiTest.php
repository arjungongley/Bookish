<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $token;
    protected $defaultHeaders;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a user
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
        
        // Get JWT token
        $this->token = auth()->guard('api')->attempt([
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        // Set default headers
        $this->defaultHeaders = [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }

    #[Test]
    public function can_get_all_books()
    {
        // Arrange
        $books = [
            [
                'title' => 'Test Book 1',
                'author' => 'Test Author 1',
                'publication_year' => 2023,
            ],
            [
                'title' => 'Test Book 2',
                'author' => 'Test Author 2',
                'publication_year' => 2024,
            ]
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        // Act
        $response = $this->withHeaders($this->defaultHeaders)
            ->getJson('/api/books');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'author',
                        'publication_year',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ])
            ->assertJsonCount(2, 'data');
    }

    #[Test]
    public function can_create_a_book()
    {
        $bookData = [
            'title' => 'New Book',
            'author' => 'New Author',
            'publication_year' => 2023,
        ];

        $response = $this->withHeaders($this->defaultHeaders)
            ->postJson('/api/books', $bookData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'author',
                    'publication_year',
                    'created_at',
                    'updated_at',
                ],
                'message'
            ])
            ->assertJson([
                'data' => $bookData,
                'message' => 'Book created successfully'
            ]);

        $this->assertDatabaseHas('books', $bookData);
    }

    #[Test]
    public function cannot_create_book_with_invalid_data()
    {
        $invalidData = [
            'title' => '',  // Invalid: empty title
            'author' => '',  // Invalid: empty author
            'publication_year' => 1400,  // Invalid: year too early
        ];

        $response = $this->withHeaders($this->defaultHeaders)
            ->postJson('/api/books', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'title' => 'The title field is required.',
                'author' => 'The author field is required.',
                'publication_year' => 'The publication year field must be at least 1500.'
            ]);
    }

    #[Test]
    public function can_update_a_book()
    {
        // Arrange
        $book = Book::create([
            'title' => 'Original Title',
            'author' => 'Original Author',
            'publication_year' => 2020,
        ]);

        $updatedData = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'publication_year' => 2021,
        ];

        // Act
        $response = $this->withHeaders($this->defaultHeaders)
            ->putJson("/api/books/{$book->id}", $updatedData);

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'author',
                    'publication_year',
                    'created_at',
                    'updated_at',
                ],
                'message'
            ])
            ->assertJson([
                'data' => $updatedData,
                'message' => 'Book updated successfully'
            ]);

        $this->assertDatabaseHas('books', $updatedData);
        $this->assertDatabaseMissing('books', [
            'title' => 'Original Title',
            'author' => 'Original Author',
            'publication_year' => 2020,
        ]);
    }

    #[Test]
    public function can_delete_a_book()
    {
        // Arrange
        $book = Book::create([
            'title' => 'Book to Delete',
            'author' => 'Author',
            'publication_year' => 2023,
        ]);

        // Act
        $response = $this->withHeaders($this->defaultHeaders)
            ->deleteJson("/api/books/{$book->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Book deleted successfully'
            ]);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);

        // Verify the book is actually deleted by trying to fetch it
        $this->withHeaders($this->defaultHeaders)
            ->getJson("/api/books/{$book->id}")
            ->assertStatus(404);
    }

    #[Test]
    public function cannot_access_books_without_token()
    {
        // Clear auth token
        auth()->guard('api')->logout();

        $endpoints = [
            ['GET', '/api/books'],
            ['POST', '/api/books'],
            ['GET', '/api/books/1'],
            ['PUT', '/api/books/1'],
            ['DELETE', '/api/books/1']
        ];

        foreach ($endpoints as [$method, $endpoint]) {
            $response = $this->json($method, $endpoint, [], [
                'Accept' => 'application/json'
            ]);

            $response->assertStatus(401);
        }
    }

    #[Test]
    public function can_get_single_book()
    {
        // Arrange
        $book = Book::create([
            'title' => 'Single Book',
            'author' => 'Single Author',
            'publication_year' => 2023,
        ]);

        // Act
        $response = $this->withHeaders($this->defaultHeaders)
            ->getJson("/api/books/{$book->id}");

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'author',
                    'publication_year',
                    'created_at',
                    'updated_at',
                ]
            ])
            ->assertJson([
                'data' => [
                    'title' => 'Single Book',
                    'author' => 'Single Author',
                    'publication_year' => 2023,
                ]
            ]);
    }

    #[Test]
    public function cannot_find_non_existent_book()
    {
        $response = $this->withHeaders($this->defaultHeaders)
            ->getJson('/api/books/999');

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Book not found',
                'message' => 'No query results for model [App\\Models\\Book] 999'
            ]);
    }
}
