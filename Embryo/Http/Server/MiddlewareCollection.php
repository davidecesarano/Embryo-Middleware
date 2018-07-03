<?php 

    /**
     * MiddlewareCollection
     * 
     * Creates a collection of middleware in relation to the position.
     * 
     * @author Davide Cesarano <davide.cesarano@unipegaso.it>
     * @link   https://github.com/davidecesarano/embryo-middleware
     * @see    https://github.com/php-fig/http-server-handler/blob/master/src/RequestHandlerInterface.php
     */

    namespace Embryo\Http\Server;

    use Embryo\Http\Server\RequestHandler;
    use Psr\Http\Server\MiddlewareInterface;

    class MiddlewareCollection extends RequestHandler
    {
        /**
         * @var array $middleware 
         */
        protected $middleware = [];

        /**
         * Adds middleware.
         *
         * @param string|MiddlewareInterface $middleware 
         */
        public function add($middleware)
        {
            if (!is_string($middleware) && !$middleware instanceof MiddlewareInterface) {
                throw new \InvalidArgumentException('Middleware must be a string or an instance of MiddlewareInterface');
            }

            $class = is_string($middleware) ? new $middleware : $middleware;
            $this->middleware[] = $class;
        }
    }