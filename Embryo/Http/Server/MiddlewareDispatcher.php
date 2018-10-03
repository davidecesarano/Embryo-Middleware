<?php
    
    /**
     * MiddlewareDispatcher
     * 
     * @author Davide Cesarano <davide.cesarano@unipegaso.it>
     * @link   https://github.com/davidecesarano/embryo-middleware
     * @see    https://github.com/php-fig/http-server-handler/blob/master/src/RequestHandlerInterface.php
     */

    namespace Embryo\Http\Server;
    
    use Psr\Container\ContainerInterface;
    use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

    class MiddlewareDispatcher extends MiddlewareCollection
    {
        /**
         * @var int $index
         */
        protected $index = 0;

        /**
         * @var ResponseInterface $response
         */
        protected $response;

        /**
         * @var ContainerInterface $container
         */
        protected $container;

        /**
         * Sets Container.
         *
         * @param ContainerInterface $container
         */
        public function __construct(ContainerInterface $container)
        {
            $this->container = $container;
        }

        /**
         * Dispatcher.
         * 
         * @param ServerRequestInterface $request 
         * @param ResponseInterface $response
         */
        public function dispatch(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
        {
            reset($this->middleware);
            $this->response = $response;
            return $this->handle($request);
        }
    }