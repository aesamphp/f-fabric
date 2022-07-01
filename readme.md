## Setup

1. git clone git@bitbucket.org:e3creative/fashion-formula.git
2. cd fashion-formula
3. composer install
4. edit .env file database configuration parameters
5. php artisan migrate --seed
6. npm install
7. bower install
8. grunt

Repeat step 8 every time you need to build style.css file. Make sure you build style.css if you make any change in scss files before you commit and push your changes.

If you make any migration or seeding changes follow the steps below after you have made your changes.

1. composer dumpautoload
2. php artisan migrate:refresh --seed

## TDD (PHPSpec)

You can use PHPSpec to write a unit tests for functionality.

## Admin / CMS

The CMS is an app inside the fashion-formula app: modules/Admin

Access via browser here: /adm1n/auth/login

Login with the admin user (see e3 wiki).

## Note

The .env file present in the root directory is your configuration file for Laravel PHP Framework. You can edit it according to your required configuration. If this file is not present in your root directory after running setup step #3 then just copy .env.example file and rename it to .env and use it.

Don't run the following command for the production environment.

1. composer update

## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
