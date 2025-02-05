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
2. Publish the Entra configuration file using `Artisan`:
   ```bash
   php artisan vendor:publish --provider="NetworkRailBusinessSystems\Entra\EntraServiceProvider" --tag="entra"
   ```
3. Adjust the `entra.php` configuration file to suit your needs.
   * `sync_attributes` will automatically create and update Models to match the details from Entra 
   * `user_model` should be the fully qualified class name of the Model used for Laravel authentication
4. Implement the `EntraAuthenticatable` interface on your chosen Model
5. Add the `AuthenticatesWithEntra` trait on your chosen Model for a standard fetch and sync setup, or implement the methods yourself
6. Add the Entra authentication routes to your `routes/web.php` using the macro:
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

### Manual sign-in and out

You can allow users to manually login by providing link to the `login` route.

Users can logout by calling the `logout` route.

## Entra sign-in response

An example of the response given by the Entra sign-in endpoint is provided for reference below.

```php
Dcblogdev\MsGraph\Events\NewMicrosoft365SignInEvent {
    +token: [
        "info" => [
            "@odata.context" => "https://graph.microsoft.com/v1.0/$metadata#users/$entity",
            "businessPhones" => [
                "01234567890",
            ],
            "displayName" => "Joe Bloggs",
            "givenName" => "Joe",
            "jobTitle" => "Business Systems Developer",
            "mail" => "Joe.Bloggs@networkrail.co.uk",
            "mobilePhone" => "01234567890",
            "officeLocation" => "Some Office",
            "preferredLanguage" => null,
            "surname" => "Bloggs",
            "userPrincipalName" => "JBloggs2@networkrail.co.uk",
            "id" => "123ab4c5-6789-01de-f2g3-45678hijk9lm",
        ],
        "accessToken" => "... A string which is ~2400 characters long ...",
        "refreshToken" => null,
        "expires" => 1234567890,
    ],
    +socket: null,
}
```
