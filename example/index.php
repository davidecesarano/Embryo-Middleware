<?php 

require __DIR__ . '/../vendor/autoload.php';

use Embryo\Http\Server\RequestHandler;
use Embryo\Http\Factory\{ServerRequestFactory, ResponseFactory};
use Middlewares\{Uuid, ResponseTime};

$request = (new ServerRequestFactory)->createServerRequestFromServer();
$response = (new ResponseFactory)->createResponse(200);

$middleware = new RequestHandler([
    Uuid::class,
    ResponseTime::class
]);
$response = $middleware->dispatch($request, $response);

echo 'X-Response-Time: ' . $response->getHeaderLine('X-Response-Time').'<br/>';
echo 'X-Uuid: ' . $response->getHeaderLine('X-Uuid').'<br/>';

echo '<pre>';
    print_r($response->getHeaders());
echo '</pre>';