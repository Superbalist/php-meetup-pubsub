<?php

namespace App\Commands;

use Superbalist\PubSub\PubSubAdapterInterface;

class ListenAllRawMessagesOnEventsChannelCommand implements CommandInterface
{
    /**
     * @var PubSubAdapterInterface
     */
    protected $adapter;

    /**
     * @param PubSubAdapterInterface $adapter
     */
    public function __construct(PubSubAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param array $options
     */
    public function run(array $options = [])
    {
        $this->adapter->subscribe('events', function ($message) {
            dump($message);
        });
    }
}
