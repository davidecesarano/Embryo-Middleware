<?php
    
    /**
     * MiddlewareDispatcher
     * 
     * Implementazione della specifica PSR 15
     * 
     * @link https://www.php-fig.org/psr/psr-15/
     */

    namespace Embryo\Http\Server;
    
    use Embryo\Http\Server\RequestHandler;
    use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
    use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};

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
         * @var ResponseInterface $response
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
         * @param ResponseInterface $response
         */
        public function dispatch(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
        {
            reset($this->middlewares);
            $this->response = $response;
            return $this->handle($request);
        }
    }