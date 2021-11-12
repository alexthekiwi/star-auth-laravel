# Star Auth Laravel

A package for Laravel that scaffolds out routes, controllers and middleware for authenticating with the Star auth app.

## Installation

You can install the package via composer:

```bash
composer require alexclark-nz/star-auth-laravel
```

Add these values to your `.env` file, and make sure your session driver is set to "database"
```
SESSION_DRIVER=database

...

AUTH_APP_URL=
AUTH_APP_CLIENT_ID=
AUTH_APP_AFTER_LOGIN_URL=
```
Run this command to create the sessions table in your database
```
php artisan session:table && php artisan migrate
```

### CSRF protection
Disable CSRF protection for the webhook route in `app\Http\Middleware\VerifyCsrfToken.php`
```php
protected $except = [
    '/auth/cb',
];
```
This is required so the auth server can make POST requests to this callback endpoint, which handles modifying the user's current session.

### Publish config:
```bash
php artisan vendor:publish --provider="AlexClark\StarAuth\StarAuthServiceProvider"
```

Add `AUTH_APP_CLIENT_ID` and `AUTH_APP_URL` to your .env file with the relevant details. Also optionally add a URL to be redirected to after successful login (`AUTH_APP_AFTER_LOGIN_URL`). This falls back to this app's base URL.

## Usage

Just protect a route with middleware. Middleware and routes are automatically registered within the package.
```php
Route::get('/protected', function () {
    return 'Only authenticated users can see this.';
})->middleware('auth.star');
```

Or a route group:
```php
Route::middleware(['auth.star'])->group(function () {
    Route::get('/protected', function () {
        return "Only authenticated users can see this.";
    });
});
```

The user will automatically be redirected to the auth server if no valid session, and sent back to their request destination after successfully logging in.
