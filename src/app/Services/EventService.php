<?php

namespace App\Services;

use Exception;
use Superbalist\EventPubSub\EventManager;
use Superbalist\EventPubSub\Events\SchemaEvent;

class EventService
{
    /**
     * @var EventManager
     */
    protected $events;

    /**
     * @var array
     */
    protected $mappings;

    /**
     * @param EventManager $events
     * @param array $mappings
     */
    public function __construct(EventManager $events, array $mappings)
    {
        $this->events = $events;
        $this->mappings = $mappings;
    }

    /**
     * Emit a client-side event.
     *
     * @param string $name
     * @param array $attributes
     * @return string
     * @throws Exception
     */
    public function emit($name, $attributes)
    {
        if (!isset($this->mappings[$name])) {
            throw new Exception(sprintf('The event "%s" is not supported.', $name));
        }

        $schema = $this->mappings[$name];

        $event = new SchemaEvent($schema, $attributes);

        $this->events->dispatch('events', $event);

        return $schema;
    }
}
