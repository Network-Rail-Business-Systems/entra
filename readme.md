# Entra

![Composer status](.github/composer.svg)
![Coverage status](.github/coverage.svg)
![Laravel version](.github/laravel.svg)
![PHP version](.github/php.svg)
![Tests status](.github/tests.svg)

Easily sign-in and poll users and groups in Microsoft Entra, built using [Laravel Microsoft Graph](https://github.com/dcblogdev/laravel-microsoft-graph). 

## Setup

1. Install this library using `Composer`:
   ```bash
   composer require networkrailbusinesssystems/entra
   ```
2. Publish the Entra configuration file and migrations using `Artisan`:
   ```bash
   php artisan vendor:publish --tag="entra"
   ```
3. Publish the MsGraph configuration file
   ```bash
   php artisan vendor:publish --provider="Dcblogdev\MsGraph\MsGraphServiceProvider" --tag="config"
   ```
   * You generally only need to set the `scopes` property
   * More information is available in the [Laravel Microsoft Graph](https://github.com/dcblogdev/laravel-microsoft-graph) documentation
4. Publish the MsGraph migration file
   ```bash
   php artisan vendor:publish --provider="Dcblogdev\MsGraph\MsGraphServiceProvider" --tag="migrations"
   ```
   * Consider adding a foreign key to the `user_id` column for greater efficiency
5. Adjust the `entra.php` configuration file to suit your needs.
   * `sync_attributes` will automatically create and update Models to match the details from Entra 
   * `user_model` should be the fully qualified class name of the Model used for Laravel authentication
6. Setup your authenticatable User model
   * Implement the `EntraAuthenticatable` interface on your chosen Model
   * Add the `AuthenticatesWithEntra` trait on your chosen Model for a standard fetch and sync setup, or implement the methods yourself
7. Add the Entra authentication routes to your `routes/web.php` using the macro:
   ```php
   Route::entra();
   
   Route::middleware('MsGraphAuthenticated')->group(function () {
       // Your authenticated routes here...
   }
   ```

## Usage

Users will automatically be redirected to the Microsoft Azure login page whenever they attempt to access an authenticated route as a guest.

The `EntraServiceProvider` automatically registers the relevant event listeners for authentication.

You can use the `Laravel Microsoft Graph` library as normal.

### Entra helper

#### Entra::findGroup()

#### Entra::findGroups()

#### Entra::findUser()

#### Entra::findUsers()

#### Entra::importUser()

### Rules

#### UserExistsInDatabase

#### UserExistsInEntra

### Emulator

#### Entra::emulate()

#### Setting up emulated users

### Manual sign-in and out

You can allow users to manually login by providing a link to the `login` route.

Users can logout by calling the `logout` route.

## Entra responses

Sample responses are provided in the `tests/Data` directory.
