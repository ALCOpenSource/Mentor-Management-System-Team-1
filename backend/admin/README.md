# Admin Backend for MMS (Mentor Management System)

## Installation

### Prerequisites

-   PHP 8.1 or higher
-   Composer

### Installation

1. Clone the repository
2. Run `composer install` to install the dependencies
3. Copy `.env.example` to `.env` and fill in the database credentials
4. Run `php artisan key:generate` to generate the application key
5. Create a database and run `php artisan migrate`
6. Run `php artisan db:seed` to seed the database with test data

## Usage

### Development

1. Run `php artisan serve` to start the development server or use Laravel Valet or Laravel Homestead

## API Response Format

We have included an APIResource class [Here](app/Http/Resources/ApiResource.php) whose purpose is to ensure that all API responses are consistent. To use it, simply extend the class and implement the `toArray()` method. The `toArray()` method should return an array with the following structure:

Example:

```php
return new ApiResource([
    // Put your data here
    'username' => 'username',
    'email' => 'email',

    // Optional
    'links' => [
        // Links to other resources
    ],
    'meta' => [
        // Meta data
    ],
    'message' => 'Used for success message',
]);
```

Incase you need to return an error, then the response should be in the following format:

```php
return new ApiResource([
    // An array of errors, used for validation errors and other errors
    'errors' => [
        'username' => 'Username is invalid'
    ],
    'error' => 'error message if it is a single error'
    'status' => 500, // Very important, this is used to set the HTTP status code
]);
```

Incase you need to return a paginated response, you can simply pass the paginator instance to the constructor:

```php
return new ApiResource(User::paginate(10));
```

## Docker

### Prerequisites

-   Docker

### Installation

Since we are using laravel vail, a docker-compose.yml file is already included in the project. To start the development server, run `docker-compose up -d` and then run `docker-compose exec app php artisan serve --host=127.0.0.1 --port=8000` to start the development server.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contributing

Thank you for considering contributing to the MMS Admin Backend! The contribution guide can be found in the [MMS Admin Backend documentation](../../README.md).

Once you have cloned the repository, you can run `composer install` to install the dependencies. You can then run `php artisan serve` to start the development server.

Please make sure to write tests for your code and to follow the [PSR-2 Coding Style Guide](https://www.php-fig.org/psr/psr-2/).

All changes should be made using the feat/ or fix/ prefix. For example, if you are adding a new feature, you should create a branch called feat/new-feature. If you are fixing a bug, you should create a branch called fix/bug-description.

Note: **Do not make changes to the master branch.**

Note: **Once you have finished making your changes, you need to fix the code styling by running `php-cs-fixer fix` and then commit your changes. You also need to run `composer test` to make sure all tests are passing. You can then push your changes to your fork and create a pull request.**

## Security Vulnerabilities

If you discover a security vulnerability within MMS Admin Backend, please open an issue. All security vulnerabilities will be promptly addressed.

## Code of Conduct

In order to ensure that the MMS Admin Backend community is welcoming to all
