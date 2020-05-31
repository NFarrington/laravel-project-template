# Laravel Project Template

A base [Laravel](https://laravel.com/) installation with additional configuration and packages.

## Installation

```bash
composer create-project --repository='{"url": "https://github.com/NFarrington/laravel-project-template.git", "type": "vcs"}' --stability dev --remove-vcs nfarrington/laravel-project-template laravel
```

## Features

This project is an expansion of the default Laravel installation.

### Additional Packages

Production:
* [Bugsnag](https://docs.bugsnag.com/platforms/php/laravel/) - third-party error detection and reporting.
* [DBAL](https://www.doctrine-project.org/projects/dbal.html) - required to change and rename database columns.

Development:
* [Debugbar](https://github.com/barryvdh/laravel-debugbar) - integrates [PHP Debug Bar](http://phpdebugbar.com/) with Laravel.
* [IDE Helper](https://github.com/barryvdh/laravel-ide-helper) - generates IDE helper files for better autocompletion.

### Docker

The project is configured to support building images via Docker Hub. Two repositories must be used, one for Nginx to serve static resources, and one for PHP FPM to serve the PHP code. When configuring builds, the environment must include `TARGET=nginx` or `TARGET=php-fpm`.

Due to limitations with Docker Hub, it is not possible to use a single repository with multiple tags.

### Travis CI

Travis CI configuration is included for building the application in a continuous integration pipeline.

This setup also supports pushing code-coverage to CodeClimate. Set `CC_TEST_REPORTER_ID` in your Travis environment to enable this.

### Miscellaneous

* If you specify a retry time when running `artisan down` the maintenance page will indicate to the user when they should try again. 
* A global helper file has been included under `app/helpers.php`.
* Additional test configuration and helpers have been provided.

## License

Licensed under the [MIT license](https://opensource.org/licenses/MIT).
