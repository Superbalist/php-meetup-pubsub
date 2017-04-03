<?php

namespace App\Commands;

use Superbalist\EventPubSub\EventManager;
use Superbalist\EventPubSub\Events\SchemaEvent;

class ListenAllEventsCommand implements CommandInterface
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
        // this command will listen to all events on the 'events' channel
        $this->events->listen('events', '*', function (SchemaEvent $event) {
            dump($event->getSchema());
            dump($event->getAttributes());
        });
    }
}
