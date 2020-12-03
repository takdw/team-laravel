# Team

## Requirements

-   PHP >7.4
-   Composer
-   MySQL/Sqlite or PostreSQL

## Installation

After cloning the repository to your local folder, run `composer install` to install all the dependencies. After that make a copy of the `.env.example` file and rename it to `.env`.

Generate an application key by running the command:

```bash
php artisan key:generate
```

You then need to head over to your database server and create a database and make a note of the name. After createing a database, go to the `.env` file and update the following environment variable keys:

```env
DB_CONNECTION=<your-database-server> # mysql, sqlite or pgsql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<the-name-of-the-database-you-just-created>
DB_USERNAME=<your-database-access-username>
DB_PASSWORD=<your-database-access-password>
```

After setting up the environemnt variables, run the command `php artisan migrate` to populate the database with the required tables.

## Serving the application

If you are on macOS, use Laravel Valet to serve the app elegantly. Otherwise, you can just run the command `php artisan serve` to server the application locally. By default the application will be hosted at `127.0.0.1` on port `8000`. You can change this by specifying your desired host address and port using the `--host=` and `--port=` options.

## Testing

The test are located in the `tests` folder. You can run the tests by running:

```bash
vendor/bin/phpunit
```
