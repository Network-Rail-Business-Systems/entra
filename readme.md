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
2. Publish the `entra.php` config file:
   ```bash
   php artisan vendor:publish --tag="entra"
   ```
   * You may skip this step if your `User` model's FQN is `App\Models\User`
   * Set the `entra.models.user` setting to your `User` model:
     ```php
     return [
         ...
         'models' => [
             'user' => User::class,
         ],
         ...
     ];
     ```
3. Adjust your `.env` to include the required settings
4. Implement the `AuthenticatesWithEntra` interface on your `User`
5. Add the Entra routes to your `routes/web.php` using the macro:
   ```php
   Route::entra();
   ```
6. Secure your other routes using the `EntraAuthenticated` middleware:
   ```php
   Route::middleware('EntraAuthenticated')->group(function () {
       // Your authenticated routes here...
   }
   ```
7. Use the `EntraTokenExists` middleware on routes which require an access token:
   ```php
   Route::middleware('EntraTokenExists')->group(function () {
       // Your authenticated token routes here...
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

The following additional settings are available in the `entra.php` configuration file:

| Config key        | Required | Default         | Notes                        |
|-------------------|----------|-----------------|------------------------------|
| entra.models.user | Yes      | App\Models\User | The FQN to your `User` model |

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

Users can visit the `entra.logout` route to sign out.

This will only sign them out of the local system, not their Entra browser session.

### Preventing Users being created

Some systems do not allow `User` models to be created automatically.

To prevent this, call `abort()` or throw an exception in your `AuthenticatesWithEntra` implementation. 

### Access Token

You can find the current `EntraAccessToken` for the logged in `User` in their session:

```php
/** @var ?EntraAccessToken $token */
$token = Session::get(Entra::ENTRA_TOKEN);
```

Entra may be expanded in the future with endpoints for use.

### Testing

Add the `AssertsEntra` trait to your testing class to use the following methods:

| Method                 | Parameters    | Returns          | Notes                                                            |
|------------------------|---------------|------------------|------------------------------------------------------------------|
| useEntraEmulator       |               | void             | Adds HTTP mocks to all Entra endpoints with successful responses |
| entraShouldFail        | string $error | void             | Causes all Entra endpoints to fail with an error message         |
| entraShouldReturnEmpty |               | void             | Causes all Entra endpoints to return an empty result set         |
| entraFakeUser          | bool $model   | EntraUser, array | Create a mock EntraUser model or dataset                         |
