<?php

namespace App\Commands;

use Superbalist\EventPubSub\EventManager;
use Superbalist\EventPubSub\Events\SchemaEvent;

class ListenAllUserCreatedVersion2EventsCommand implements CommandInterface
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
        // this command will listen to all events on the 'events' channel which match the 'user' topic,
        // the 'created' event and version 2
        $this->events->listen('events', 'user/created/2.0', function (SchemaEvent $event) {
            dump($event->getSchema());
            dump($event->getAttributes());
        });
    }
}
