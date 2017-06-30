# Route Redirector

Redirect Responses direct from your routes file.

# Install

```
composer require vluzrmos/laravel-route-redirector
```

# Configuration

Put the package Middlware in your Http Kernel file (usually in `app/Http/Kernel.php`):

```php

    protected $routeMiddleware = [
        \\...
        'redirect' => \Vluzrmos\RouteRedirector\RouteRedirectorMiddleware::class
    ];
```

# Usage

```php 
// redirect the user from /home to a route named "dashboard" (short syntax)
Route::get('/home', ['middleware' => 'redirect:route,dashboard']);
 
//or
Route::get('/home', ['middleware' => 'redirect', 'redirect_route' => 'dashboard']);

// Redirect User to a local path
Route::get('/home', ['middleware' => 'redirect', 'redirect_to' => '/profile']);

// Redirect User away (without prefixing with app domain)
Route::get('/home', ['middleware' => 'redirect', 'redirect_away' => '/profile']);

//using fully route parameters

Route::get('/home', ['middleware' => 'redirect', 'redirect_route' => [$name = 'dashboard', $parameters = ['something' => 'else'], $statusCode = 302, $headers ...]]);
Route::get('/home', ['middleware' => 'redirect', 'redirect_to' => [$path = '/profile', $statusCode = 302, $headers ...]]);
Route::get('/home', ['middleware' => 'redirect', 'redirect_away' => [$path = '/profile', $statusCode = 302, $headers ...]]);
Route::get('/home', ['middleware' => 'redirect', 'redirect_action' => [$action = 'Controller@method', $parameters = ['something' => 'else'], $statusCode = 302, $headers ...]]);


// all methods can be used with short syntax:

Route::get('/home', ['middleware' => 'redirect:route,dashboard']);
Route::get('/home', ['middleware' => 'redirect:to,dashboard']);
Route::get('/home', ['middleware' => 'redirect:away,path']);
Route::get('/home', ['middleware' => 'redirect:action,FQDN\Controller@method']);

```
