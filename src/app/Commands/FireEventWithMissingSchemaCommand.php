<?php

namespace App\Commands;

use Superbalist\EventPubSub\EventManager;
use Superbalist\EventPubSub\Events\SchemaEvent;

class FireEventWithMissingSchemaCommand implements CommandInterface
{
    /**
     * @var EventManager
     */
    protected $events;

    /**
     * @param EventManager $events
     */
    public function __construct(EventManager $events)
    {
        $this->events = $events;
    }

    /**
     * @param array $options
     */
    public function run(array $options = [])
    {
        $event = new SchemaEvent(
            'http://php-meetup-pubsub.dev/schemas/events/order/created/1.0.json',
            [
                'order' => [
                    'id' => 1234,
                    'hello' => 'world',
                ],
            ]
        );
        $this->events->dispatch('events', $event);
    }
}
