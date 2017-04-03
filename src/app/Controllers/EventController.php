<?php

namespace App\Controllers;

use App\Services\EventService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EventController
{
    /**
     * @var EventService
     */
    protected $eventService;

    /**
     * @param EventService $eventService
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Emit a client-side event.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function postEmit(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $params = $request->getParsedBody();
        $name = isset($params['name']) ? $params['name'] : null;
        $attributes = isset($params['params']) ? $params['params'] : [];
        $schema = $this->eventService->emit($name, $attributes);
        return $response->withJson([
            'message' => sprintf('You just triggered the "%s" event!', $schema),
        ]);
    }
}
