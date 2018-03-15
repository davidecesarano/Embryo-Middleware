<?php 

require __DIR__ . '/../vendor/autoload.php';

use Middleware\MiddlewareDispatcher;
use Zend\Diactoros\{ServerRequestFactory, Response};
use Middlewares\{Uuid, ResponseTime};

$request = ServerRequestFactory::fromGlobals();
$response = new Response;

$middleware = new MiddlewareDispatcher;
$middleware->add(new Uuid);
$middleware->add(new ResponseTime);
$response = $middleware->dispatch($request, $response);

echo 'X-Response-Time: ' . $response->getHeaderLine('X-Response-Time').'<br/>';
echo 'X-Uuid: ' . $response->getHeaderLine('X-Uuid').'<br/>';

echo '<pre>';
    print_r($response->getHeaders());
echo '</pre>';