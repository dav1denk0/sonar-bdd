## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/downloads.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Sonar BDD Project

Sonar BDD is a project with testing purpose over the Sonar Service Project. Sonar is a service to store and normalize information about places from different providers.

In this case, we're using Behat to test the Sonar features in a Behavior Driven Development way. Also, frameworks like Laravel, Composer and Guzzle are also used in this project.
This project was developed in a trial version of PhpStorm 8 IDE under Windows OS. And the PHP language version is the following:

    PHP 5.5.25 (cli) (built: May 13 2015 19:58:58)
    Copyright (c) 1997-2015 The PHP Group
    Zend Engine v2.5.0, Copyright (c) 1998-2015 Zend Technologies

## Project Setup

First of all open a command window and go to the project root folder. We need to install Composer by running in a command window:

    curl -s http://getcomposer.org/installer | php

Then, we already had a composer.json file in our project root with all the dependencies that we need to get the Sonar BDD project working.
To install all dependencies (behat, laravel, guzzle, etc.) we need to execute the following command:

    php composer.phar install
    
If any change was made in composer.json file we need to 'update' composer to take changes and to download new dependencies.

    composer update
    
Please, if you have any problems with the previous command and your dependencies are not in /vendor folder, try to execute the previous composer update command
