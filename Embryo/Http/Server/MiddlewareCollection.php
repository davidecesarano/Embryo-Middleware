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
         * @param string $middleware 
         */
        public function add(string $middleware)
        {
            $class = new $middleware($this->container);
            if (!$class instanceof MiddlewareInterface) {
                throw new \InvalidArgumentException('Middleware must be a an instance of MiddlewareInterface');
            }
            $this->middleware[] = $class;
        }
    }