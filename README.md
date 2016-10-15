# Laravel-Email-Templates-Optimization
> Optimize your email templates styles via native Laravel templating mechanism.

[![Build Status](https://travis-ci.org/mlanin/laravel-email-templates-optimization.svg?branch=master)](https://travis-ci.org/mlanin/laravel-email-templates-optimization)
[![Code Coverage](https://scrutinizer-ci.com/g/mlanin/laravel-email-templates-optimization/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mlanin/laravel-email-templates-optimization/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mlanin/laravel-email-templates-optimization/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mlanin/laravel-email-templates-optimization/?branch=master)

If you want to send an HTML email you can't just send it with `<style></style>` tag in it, or link a stylesheet. Most of the email clients will cut it and clients will see your email without any styles.

The only approach to achieve best email quality is to convert all your styles int inline `style=""` attributes like this:

#### Source
```html
<!DOCTYPE html>
<html>
<head>
  <title>Hello World</title>
  <style>
    body {
      font-size: 14px;
    }
    h1 {
      font-size: 20px;
    }
    a {
      color: #333;
    }
  </style>
</head>
<body>
  <h1>Hello!</h1>
  <p class="content">
    <a href="https://laravel.com">Laravel</a>
  </p>
</body>
</html>
```

#### Result
```html
<!DOCTYPE html>
<html>
<head>
  <title>Hello World</title>
</head>
<body style="font-size: 14px;">
  <h1 style="font-size: 20px;">Hello!</h1>
  <p class="content">
    <a href="https://laravel.com" style="color: #333;">Laravel</a>
  </p>
</body>
</html>
```

## How to achieve that?

- You can precompile your templates, and store and send them as is. But your compiled templates will become too hard to maintain.
- Or you can compile them on every email send like in https://github.com/fedeisas/laravel-mail-css-inliner package. But it will cause an enormous overhead.

With this in mind I made this engine. It compiles css into email templates and at the same time utilises native Laravel's Blade syntax and compile-and-cache approach.

This means that you can store your email templates as before and they will be compiled on the fly and then cached in order not to recompile every time!

## Installation

[PHP](https://php.net) 5.5.9+ or [HHVM](http://hhvm.com) 3.3+, [Composer](https://getcomposer.org) and [Laravel](http://laravel.com) 5.1+ are required.

To get the latest version of Laravel-Email-Templates-Optimization, simply install it via composer.

```bash
$ composer require "lanin/laravel-email-templates-optimization:0.1.*"
```

Once package is installed, you need to register the service provider. Open up `config/app.php` and add the following to the providers key.

```php
Lanin\Laravel\EmailTemplatesOptimization\ServiceProvider::class,
```

## Usage

What you have to do is just rename your email templates' files from `*.blade.php` to `*.email.php` and that's it! This Engine will do the rest for you!

## Configuration

Furthermore you can tell the engine what static css files to use with your templates to not duplicate them in each of them.

For this you set copy this into your view.php config:

```php
    'emails' => [
        /*
        |--------------------------------------------------------------------------
        | Css Files
        |--------------------------------------------------------------------------
        |
        | List of absolute paths to static css files to use in your email templats.
        |
        | Example: realpath(resource_path('assets/css/emails.css'))
        |
        */
        'css_files' => [
        
        ],
    ],
```

## Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance the functionalities.