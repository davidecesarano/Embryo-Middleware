<?php 

    /**
     * RequestHandler
     * 
     * Handle the request and return a response.
     * 
     * @author Davide Cesarano <davide.cesarano@unipegaso.it>
     * @link   https://github.com/davidecesarano/embryo-middleware
     * @see    https://github.com/php-fig/http-server-handler/blob/master/src/RequestHandlerInterface.php
     */

    namespace Embryo\Http\Server;

    use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
    use Psr\Http\Server\RequestHandlerInterface;

    class RequestHandler implements RequestHandlerInterface
    {
        /**
         * Handle the request, return a response and calls
         * next middleware.
         * 
         * @param ServerRequestInterface $request 
         * @return ResponseInterface
         */
        public function handle(ServerRequestInterface $request): ResponseInterface
        {
            if (!isset($this->middlewares[$this->index])) {
                return $this->response;
            }
    
            $middleware = $this->middlewares[$this->index];
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