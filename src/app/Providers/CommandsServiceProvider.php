<?php

namespace App\Providers;

use App\Commands\CommandRegistry;
use App\Commands\FireEventWithMissingSchemaCommand;
use App\Commands\ListenAllEventsCommand;
use App\Commands\ListenAllRawMessagesOnEventsChannelCommand;
use App\Commands\ListenAllUserCreatedEventsCommand;
use App\Commands\ListenAllUserCreatedVersion1EventsCommand;
use App\Commands\ListenAllUserCreatedVersion2EventsCommand;
use App\Commands\ListenAllUserTopicEventsCommand;
use Psr\Container\ContainerInterface;
use Superbalist\EventPubSub\EventManager;
use Superbalist\PubSub\PubSubAdapterInterface;

class CommandsServiceProvider extends ServiceProvider
{
    /**
     * Register a service provider.
     */
    public function register()
    {
        $this->container[CommandRegistry::class] = function (ContainerInterface $container) {
            $registry = new CommandRegistry($container);
            $registry->register(
                'listen-all-raw-messages-on-events-channel',
                ListenAllRawMessagesOnEventsChannelCommand::class
            );
            $registry->register('listen-all-events', ListenAllEventsCommand::class);
            $registry->register('listen-all-user-topic-events', ListenAllUserTopicEventsCommand::class);
            $registry->register('listen-all-user-created-events', ListenAllUserCreatedEventsCommand::class);
            $registry->register('listen-all-user-created-v1-events', ListenAllUserCreatedVersion1EventsCommand::class);
            $registry->register('listen-all-user-created-v2-events', ListenAllUserCreatedVersion2EventsCommand::class);
            $registry->register('fire-event-with-missing-schema', FireEventWithMissingSchemaCommand::class);
            return $registry;
        };

        $this->container[ListenAllRawMessagesOnEventsChannelCommand::class] = function (ContainerInterface $container) {
            $adapter = $container->get(PubSubAdapterInterface::class);
            return new ListenAllRawMessagesOnEventsChannelCommand($adapter);
        };

        $this->container[ListenAllEventsCommand::class] = function (ContainerInterface $container) {
            $events = $container->get(EventManager::class);
            return new ListenAllEventsCommand($events);
        };

        $this->container[ListenAllUserTopicEventsCommand::class] = function (ContainerInterface $container) {
            $events = $container->get(EventManager::class);
            return new ListenAllUserTopicEventsCommand($events);
        };

        $this->container[ListenAllUserCreatedEventsCommand::class] = function (ContainerInterface $container) {
            $events = $container->get(EventManager::class);
            return new ListenAllUserCreatedEventsCommand($events);
        };

        $this->container[ListenAllUserCreatedVersion1EventsCommand::class] = function (ContainerInterface $container) {
            $events = $container->get(EventManager::class);
            return new ListenAllUserCreatedVersion1EventsCommand($events);
        };

        $this->container[ListenAllUserCreatedVersion2EventsCommand::class] = function (ContainerInterface $container) {
            $events = $container->get(EventManager::class);
            return new ListenAllUserCreatedVersion2EventsCommand($events);
        };

        $this->container[FireEventWithMissingSchemaCommand::class] = function (ContainerInterface $container) {
            $events = $container->get(EventManager::class);
            return new FireEventWithMissingSchemaCommand($events);
        };
    }
}
