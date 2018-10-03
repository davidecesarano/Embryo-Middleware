# Embryo Middleware
Simple dispatcher ([PSR-15](https://www.php-fig.org/psr/psr-15/) server request handler) for a queue of PSR-15 middleware entries. Request handlers and middleware components are a fundamental part of any web application. Server side code receives a request message, processes it, and produces a response message. HTTP middleware is a way to move common request and response processing away from the application layer.

## Requirements
* PHP >= 7.1
* A [PSR-7](https://www.php-fig.org/psr/psr-7/) http message implementation (ex. [Embryo-Http](https://github.com/davidecesarano/embryo-http))
* A [PSR-11](https://www.php-fig.org/psr/psr-11/) container implementation (ex. [Embryo-Container](https://github.com/davidecesarano/embryo-container))

## Installation
```
$ composer require davidecesarano/embryo-middleware
```

## Usage
The MiddlewareDispatcher is a container for a queue of PSR-15 middleware. It takes two methods:
* the method `add` appends the middleware to create a queue of middleware entries.
* the method `dispatch` requires two arguments, a `ServerRequest` object and a `Response` object (used by terminator to return an empty response).

## Example
### Set ServerRequest and Response
Create `ServerRequest` and `Response` objects.

```php
use Embryo\Container\Container;
use Embryo\Http\Server\MiddlewareDispatcher;
use Embryo\Http\Factory\{ServerRequestFactory, ResponseFactory};
use Middlewares\{Uuid, ResponseTime};
use Psr\Http\Message\ServerRequestInterface;

// PSR-7 implementation
$request = (new ServerRequestFactory)->createServerRequestFromServer();
$response = (new ResponseFactory)->createResponse(200);

// PSR-11 implementation
$container = new Container;
```

### Add middleware
Create a queue of PSR-15 middleware with the `add` method. In this example we use two PSR-15 compatible middleware: [Uuid Middleware](https://github.com/middlewares/uuid) and [ResponseTime Middleware](https://github.com/middlewares/response-time).

```php
// PSR-15 MiddlewareInterface implementation
$middleware = new MiddlewareDispatcher($container);
$middleware->add(Uuid::class);
$middleware->add(ResponseTime::class);
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
