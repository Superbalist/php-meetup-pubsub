<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages;

class ValidationErrorRedirectMiddleware
{
    /**
     * @var Messages
     */
    protected $flash;

    /**
     * @param Messages $flash
     */
    public function __construct(Messages $flash)
    {
        $this->flash = $flash;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if ($request->getAttribute('has_errors')) {
            foreach ($request->getAttribute('errors') as $field => $messages) {
                foreach ($messages as $message) {
                    $this->flash->addMessage('errors', $message);
                }
            }

            $uri = $request->getServerParams()['REQUEST_URI'];
            return $response->withStatus(302)
                ->withHeader('Location', $uri);
        } else {
            return $next($request, $response);
        }
    }
}
