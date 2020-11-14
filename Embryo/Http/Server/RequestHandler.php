<?php 

    /**
     * RequestHandler
     * 
     * Create a collection of middleware, 
     * handle the request and return a response.
     * 
     * @author Davide Cesarano <davide.cesarano@unipegaso.it>
     * @link   https://github.com/davidecesarano/embryo-middleware
     * @see    https://github.com/php-fig/http-server-handler/blob/master/src/RequestHandlerInterface.php
     */

    namespace Embryo\Http\Server;

    use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
    use Psr\Http\Server\{MiddlewareInterface, RequestHandlerInterface};

    class RequestHandler implements RequestHandlerInterface
    {
        /**
         * @var int $index
         */
        protected $index = 0;

        /**
         * @var array $middleware 
         */
        protected $middleware = [];
        
        /**
         * @var ResponseInterface $response 
         */
        protected $response;

        /**
         * Add middleware queue.
         *
         * @param array $middleware
         */
        public function __construct(array $middleware = [])
        {
            array_map([$this, 'add'], $middleware);
        }
        
        /**
         * Add a middleware to the end of the queue.
         *
         * @param string|MiddlewareInterface $middleware
         * @return void 
         * @throws \InvalidArgumentException 
         */
        public function add($middleware)
        {
            if (!is_string($middleware) && !$middleware instanceof MiddlewareInterface) {
                throw new \InvalidArgumentException('Middleware must be a string or an instance of MiddlewareInterface');
            }

            $class = is_string($middleware) ? new $middleware : $middleware;
            array_push($this->middleware, $class);
        }

        /**
         * Add a middleware to the beginning of the queue.
         *
         * @param string|MiddlewareInterface $middleware 
         * @return void 
         * @throws \InvalidArgumentException  
         */
        public function prepend($middleware)
        {
            if (!is_string($middleware) && !$middleware instanceof MiddlewareInterface) {
                throw new \InvalidArgumentException('Middleware must be a string or an instance of MiddlewareInterface');
            }

            $class = is_string($middleware) ? new $middleware : $middleware;
            array_unshift($this->middleware, $class);
        }

        /**
         * Dispatch the middleware queue.
         * 
         * @param ServerRequestInterface $request 
         * @param ResponseInterface $response
         * @return ResponseInterface
         */
        public function dispatch(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
        {
            reset($this->middleware);
            $this->response = $response;
            return $this->handle($request);
        }

        /**
         * Handle the request, return a response and calls
         * next middleware.
         * 
         * @param ServerRequestInterface $request 
         * @return ResponseInterface
         */
        public function handle(ServerRequestInterface $request): ResponseInterface
        {
            if (!isset($this->middleware[$this->index])) {
                return $this->response;
            }
    
            $middleware = $this->middleware[$this->index];
            return $middleware->process($request, $this->next());
        }

        /**
         * Next middleware.
         * 
         * @return static
         */
        private function next()
        {
            $clone = clone $this;
            $clone->index++;
            return $clone;
        }
    }