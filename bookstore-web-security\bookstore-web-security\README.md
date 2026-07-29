# Bookstore Web Security Project

## Overview
This project is a Laravel-based bookstore application designed to simulate web security practices. It includes user authentication, book management, and shopping cart functionalities, all while adhering to security best practices.

## Features
- **User Authentication**: Users can register, log in, and manage their profiles.
- **Book Management**: Admins can create, read, update, and delete books.
- **Shopping Cart**: Users can add books to their cart and manage their orders.
- **Security Middleware**: Implements security checks for incoming requests and admin access.

## Directory Structure
```
bookstore-web-security
├── app
│   ├── Http
│   │   ├── Controllers
│   │   ├── Middleware
│   │   └── Requests
│   ├── Models
│   └── Providers
├── config
├── database
│   ├── migrations
│   ├── seeders
│   └── factories
├── public
├── resources
│   ├── views
│   └── lang
├── routes
├── storage
├── tests
├── .env
├── .env.example
├── artisan
├── composer.json
└── phpunit.xml
```

## Installation
1. **Clone the repository**:
   ```
   git clone <repository-url>
   cd bookstore-web-security
   ```

2. **Install dependencies**:
   ```
   composer install
   ```

3. **Set up the environment**:
   - Copy `.env.example` to `.env` and configure your database settings.
   - Run `php artisan key:generate` to generate the application key.

4. **Run migrations**:
   ```
   php artisan migrate
   ```

5. **Seed the database** (optional):
   ```
   php artisan db:seed
   ```

6. **Start the server**:
   ```
   php artisan serve
   ```

## Usage
- Access the application at `http://localhost:8000`.
- Use the authentication features to register and log in.
- Admin users can manage books and view orders.

## Testing
Run the tests using:
```
php artisan test
```

## License
This project is licensed under the MIT License.