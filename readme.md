# Entra

![Composer status](.github/composer.svg)
![Coverage status](.github/coverage.svg)
![Laravel version](.github/laravel.svg)
![PHP version](.github/php.svg)
![Tests status](.github/tests.svg)

Easily sign-in and poll users and groups in Microsoft Entra. 

## Roadmap

* Users authenticate with Entra
* If Code is returned, check whether they are a guest
* If not, get access token as normal
* If so, use generic account
* If generic account does not have token, use certificate flow to get one


## User Library version

* Users authenticate with Entra
* Library uses Entra job to list and download user details where they are actual people and not generic accounts
* Library uses Entra job to list and download group details where they have at least one member
