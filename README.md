<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"># Bookish - Laravel Book Library API

A RESTful API for managing a book library using Laravel with JWT authentication.

## Features

- JWT Authentication
- CRUD operations for books
- Input validation
- Error handling with try-catch blocks
- MySQL database with migrations and seeders
- Comprehensive test suite with PHPUnit
- JWT authentication using php-open-source-saver/jwt-auth

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL/MariaDB

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd bookish
```

2. Install dependencies:
```bash
composer install
```

3. Create environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure the database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bookish
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Generate JWT secret:
```bash
php artisan jwt:secret
```

7. Run migrations and seeders:
```bash
php artisan migrate --seed
```

8. Start the development server:
```bash
php artisan serve
```

## API Endpoints

### Authentication

#### Register
```
POST /api/register
```
Parameters:
- name (required, string)
- email (required, email)
- password (required, min:6)

#### Login
```
POST /api/login
```
Parameters:
- email (required, email)
- password (required)

#### Logout
```
POST /api/logout
```
Requires authentication

#### Refresh Token
```
POST /api/refresh
```
Requires authentication

### Books

All book endpoints require authentication via JWT token in the Authorization header:
```
Authorization: Bearer <your-jwt-token>
```

#### List all books
```
GET /api/books

Response 200:
{
    "data": [
        {
            "id": 1,
            "title": "Book Title",
            "author": "Author Name",
            "publication_year": 2023,
            "created_at": "2023-01-01T00:00:00.000000Z",
            "updated_at": "2023-01-01T00:00:00.000000Z"
        }
    ]
}
```

#### Get one book
```
GET /api/books/{id}
```

#### Create a book
```
POST /api/books
```
Parameters:
- title (required, string)
- author (required, string)
- publication_year (required, integer, between:1500-current_year)

#### Update a book
```
PUT /api/books/{id}
```
Parameters:
- title (required, string)
- author (required, string)
- publication_year (required, integer, between:1500-current_year)

#### Delete a book
```
DELETE /api/books/{id}
```

## Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/BookApiTest.php
```

### Test Coverage
The test suite includes comprehensive tests for:
- Authentication (JWT token validation)
- Book CRUD operations with proper response structures
- Input validation with specific error messages
- Unauthorized access prevention for all endpoints
- Database state verification after operations
- Error handling for non-existent resources

### Writing Tests
Tests are written using PHPUnit and Laravel's testing utilities. Key points:
- Uses `RefreshDatabase` trait to reset database state
- JWT authentication is handled via the `auth:api` middleware
- Tests include both happy path and error cases
- Assertions verify both response structure and content
- Database assertions confirm proper state changes

## Error Handling

All endpoints are wrapped in try-catch blocks and return appropriate HTTP status codes and structured responses:

```json
// 200: Success
{
    "data": { ... },
    "message": "Operation successful"
}

// 201: Created
{
    "data": { ... },
    "message": "Resource created successfully"
}

// 400: Bad Request
{
    "error": "Validation failed",
    "message": "The given data was invalid"
}

// 401: Unauthorized
{
    "message": "Unauthenticated"
}

// 404: Not Found
{
    "error": "Resource not found",
    "message": "No query results for model"
}

// 422: Validation Error
{
    "message": "The given data was invalid",
    "errors": {
        "field": ["Validation error message"]
    }
}

// 500: Server Error
{
    "error": "Server error",
    "message": "Internal server error"
}
```

## Security

- All endpoints (except login and register) require JWT authentication
- Passwords are hashed using Laravel's built-in hashing
- Input validation for all requests
- CORS protection
- SQL injection protection through Laravel's query builder

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development/)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/BookApiTest.php
```

### Test Coverage
The test suite includes:
- Authentication tests (register, login, logout)
- Book CRUD operations
- Input validation
- Unauthorized access prevention
- JWT token handling

## Database Seeding

### Available Seeders
- UserSeeder: Creates test users
- BookSeeder: Populates sample books

### Running Seeders
```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=BookSeeder
```

## Project Structure

```
bookish/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AuthController.php
│   │   │       └── BookController.php
│   │   ├── Requests/
│   │   │   └── BookRequest.php
│   │   └── Middleware/
│   │       └── Authenticate.php
│   └── Models/
│       ├── User.php
│       └── Book.php
├── database/
│   ├── migrations/
│   │   └── books_table.php
│   └── seeders/
│       ├── UserSeeder.php
│       └── BookSeeder.php
├── routes/
│   └── api.php
└── tests/
    └── Feature/
        └── BookApiTest.php
```

## API Documentation

This project uses Swagger/OpenAPI for API documentation. After starting the development server, you can access the interactive API documentation at:

```
http://127.0.0.1:8000/api/documentation
```

The documentation includes:
- Detailed endpoint descriptions
- Request/response schemas
- Authentication requirements
- Example requests and responses
- Interactive API testing interface

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
