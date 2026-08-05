# Entra

![Composer status](.github/composer.svg)
![Coverage status](.github/coverage.svg)
![Laravel version](.github/laravel.svg)
![PHP version](.github/php.svg)
![Tests status](.github/tests.svg)

Authenticate users with Entra Single Sign On

## Limitations

Due to Network Rail policies, Entra applications cannot be given application level access.

As such, we cannot poll Entra directly with guest users.

Since our systems require guests to be able to poll the directory, Entra can only be used for authentication.

## Installation

1. Install using Composer:
   ```bash
   composer require networkrailbusinesssystems/entra
   ```
2. Adjust your `.env` to include the required settings
3. Implement the `AuthenticatesWithEntra` interface on your `User`
4. Add the Entra routes to your `routes/web.php` using the macro:
   ```php
   Route::entra();
   ```
5. Secure your other routes using the `EntraAuthenticated` middleware:
   ```php
   Route::middleware('EntraAuthenticated')->group(function () {
       // Your authenticated routes here...
   }
   ```

## Configuration

The following settings can be changed in your `.env`:

| .env key        | Config key      | Required | Notes                                         |
|-----------------|-----------------|----------|-----------------------------------------------|
| ENTRA_CLIENT    | entra.client    | Yes      | The Entra application / client ID             |
| ENTRA_PROXY     | entra.proxy     | No       | The proxy URL to use for connecting to Entra  |
| ENTRA_SCOPES    | entra.scopes    | No       | The scopes to use when polling Entra          |
| ENTRA_SECRET    | entra.secret    | Yes      | The Entra application secret                  |
| ENTRA_TENANT    | entra.tenant    | Yes      | The Entra directory / tenant ID               |

## Usage

There are two main ways to use this library:

1. Automatic login
2. User initiated login

### Automatic login

To automatically login Users across the entire system, simply wrap all your `web` routes in `EntraAuthenticated`.

### User initiated login

If some pages should be available without a login, only wrap the needed `web` routes in `EntraAuthenticated`.

When users attempt to access those pages they will be logged in automatically.

You could also provide a `Sign in` or `Login` button someone on your interface which points to the `entra.login` route.

### Signing out

Signing out is not provided by this library, but could be implemented if required.

### Preventing Users being created

Some systems do not allow `User` models to be created automatically.

To prevent this, call `abort()` or throw an exception in your `AuthenticatesWithEntra` implementation. 
