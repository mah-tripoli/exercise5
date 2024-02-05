#  Book Rental Library - Exercise 5

Expand the book rental library application by adding an API layer. This API will allow users to interact with the application programmatically, enabling actions like viewing available books, and renting books. Testing will ensure that both the web and API components of the application function correctly.

## Installation

- Copy `.env.example` to `.env`: `copy .env.example .env`
- Run `composer install`
- Run `php artisan key:generate --ansi`
- Update database details in `.env`
- Run `php artisan migrate`
- Run `php artisan db:seed --class=GenresTableSeeder`
- Run `php artisan db:seed --class=BooksTableSeeder`

## Admin Account

To create an admin account run:

`php artisan db:seed --class=AdminSeeder`

## Public files

To make public  files accessible run: `php artisan storage:link`

## Run Application

Run `php artisan serve` or open project from browser: `http://localhost/laravel-project/public`.

## Testing

Run `php artisan test`

## Topics

- [Eloquent: API Resources](https://laravel.com/docs/10.x/eloquent-resources)
- [Testing](https://laravel.com/docs/10.x/testing)
