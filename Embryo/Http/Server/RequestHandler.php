<?php 

    /**
     * RequestHandler
     * 
     * Gestisce una richiesta del server e produce una risposta
     * 
     * @link https://github.com/php-fig/http-server-handler/blob/master/src/RequestHandlerInterface.php
     */

    namespace Embryo\Http\Server;

    use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
    use Psr\Http\Server\RequestHandlerInterface;

    class RequestHandler implements RequestHandlerInterface
    {
        /**
         * Gestisce richiesta e produce una risposta 
         * richiamando i middleware succcessivi
         * 
         * @param ServerRequestInterface $request 
         * @return ResponseInterface
         */
        public function handle(ServerRequestInterface $request): ResponseInterface
        {
            if (empty($this->middlewares[$this->index])) {
                return call_user_func([$this, 'response'], $request);
            }
    
            $middleware = $this->middlewares[$this->index];
            return $middleware->process($request, $this->next());
        }

        /**
         * Risposta
         * 
         * @param ServerRequestInterface $request 
         * @return ResponseInterface
         */
        private function response(ServerRequestInterface $request): ResponseInterface
        {
            return $this->response;
        }

        /**
         * Middleware successivo
         */
        private function next()
        {
            $clone = clone $this;
            $clone->index++;
            return $clone;
        }
    }