<?php
    
    /**
     * MiddlewareDispatcher
     * 
     * Implementazione della specifica PSR 15
     * 
     * @link https://www.php-fig.org/psr/psr-15/
     */

    namespace Middleware;
    
    use Middleware\RequestHandler;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Server\MiddlewareInterface;
    use Psr\Http\Server\RequestHandlerInterface;

    class MiddlewareDispatcher extends RequestHandler
    {
        /**
         * @var array $middleware 
         */
        protected $middlewares = [];

        /**
         * @var int $index
         */
        protected $index = 0;
        
        /**
         * @var callable $response
         */
        protected $response;

        /**
         * Aggiunge middleware 
         *
         * @param MiddlewareInterface $middleware 
         */
        public function add(MiddlewareInterface $middleware)
        {
            $this->middlewares[] = $middleware;
        }

        /**
         * Esegue il dispatch dei middleware
         * 
         * @param ServerRequestInterface $request 
         * @param callable $response
         */
        public function dispatch(ServerRequestInterface $request, callable $response): ResponseInterface
        {
            reset($this->middlewares);
            $this->response = $response;
            return $this->handle($request);
        }
    }