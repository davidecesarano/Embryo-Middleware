# Embryo Middleware
Simple dispatcher ([PSR-15](https://www.php-fig.org/psr/psr-15/) server request handler) for a queue of PSR-15 middleware entries. Request handlers and middleware components are a fundamental part of any web application. Server side code receives a request message, processes it, and produces a response message. HTTP middleware is a way to move common request and response processing away from the application layer.

## Requirements
* PHP >= 7.1
* A [PSR-7](https://www.php-fig.org/psr/psr-7/) http message implementation and [PSR-17](https://www.php-fig.org/psr/psr-17/) http factory implementation (ex. [Embryo-Http](https://github.com/davidecesarano/embryo-http))

## Installation
Using Composer:
```
$ composer require davidecesarano/embryo-middleware
```

## Usage
The RequestHandler is a container for a queue of PSR-15 middleware. It takes three methods:
* the method `add` add a middleware to the end of the queue.
* the method `prepend` add a middleware to the beginning of the queue.
* the method `dispatch` requires two arguments, a `ServerRequest` object and a `Response` object (used by terminator to return an empty response).

### Set ServerRequest and Response
Create `ServerRequest` and `Response` objects.

```php
use Embryo\Http\Server\RequestHandler;
use Embryo\Http\Factory\{ServerRequestFactory, ResponseFactory};
use Middlewares\{Uuid, ResponseTime};
use Psr\Http\Message\ServerRequestInterface;

// PSR-7 implementation
$request = (new ServerRequestFactory)->createServerRequestFromServer();
$response = (new ResponseFactory)->createResponse(200);
```

### Add middleware
Create a queue of PSR-15 middleware with the `add` method or `constructor`. 
The add (and prepend) method must be a string or a instance of MiddlewareInterface. In constructor you may create a queue with array of string or instance of MiddlewareInterface.

In this example we use two PSR-15 compatible middleware: [Uuid Middleware](https://github.com/middlewares/uuid) and [ResponseTime Middleware](https://github.com/middlewares/response-time).

```php
// PSR-15 MiddlewareInterface implementation
$middleware = new RequestHandler([
    Uuid::class,
    ResponseTime::class
]);
$response = $middleware->dispatch($request, $response);
```

### Result
The dispatch produces a response messages.

```php
echo 'X-Response-Time: ' . $response->getHeaderLine('X-Response-Time').'<br/>';
echo 'X-Uuid: ' . $response->getHeaderLine('X-Uuid').'<br/>';

echo '<pre>';
    print_r($response->getHeaders());
echo '</pre>';
```

### Example
You may quickly test this using the built-in PHP server going to http://localhost:8000.
```
$ cd example
$ php -S localhost:8000
```