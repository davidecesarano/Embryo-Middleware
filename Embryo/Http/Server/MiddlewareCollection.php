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
         * @var array $before 
         */
        protected $before = [];

        /**
         * @var array $routes 
         */
        protected $route = [];

        /**
         * @var array $after 
         */
        protected $after = [];

        /**
         * Adds middleware.
         *
         * @param MiddlewareInterface $middleware 
         */
        public function add(MiddlewareInterface $middleware)
        {
            $this->before[] = $middleware;
        }

        /**
         * Adds route like middleware.
         *
         * @param MiddlewareInterface $middleware 
         */
        public function addRoute(MiddlewareInterface $middleware)
        {
            $this->route[] = $middleware;
        }

        /**
         * Adds middleware after routing.
         *
         * @param MiddlewareInterface $middleware 
         */
        public function addAfterRouting(MiddlewareInterface $middleware)
        {
            $this->after[] = $middleware;
        }
    }