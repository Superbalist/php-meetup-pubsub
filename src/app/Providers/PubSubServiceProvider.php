<?php

namespace App\Providers;

use League\JsonGuard\Dereferencer;
use Predis\Client as RedisClient;
use Psr\Container\ContainerInterface;
use Superbalist\EventPubSub\AttributeInjectors\DateAttributeInjector;
use Superbalist\EventPubSub\AttributeInjectors\HostnameAttributeInjector;
use Superbalist\EventPubSub\AttributeInjectors\Uuid4AttributeInjector;
use Superbalist\EventPubSub\EventManager;
use Superbalist\EventPubSub\EventValidatorInterface;
use Superbalist\EventPubSub\MessageTranslatorInterface;
use Superbalist\EventPubSub\Translators\SchemaEventMessageTranslator;
use Superbalist\EventPubSub\Validators\JSONSchemaEventValidator;
use Superbalist\PubSub\PubSubAdapterInterface;
use Superbalist\PubSub\Redis\RedisPubSubAdapter;

class PubSubServiceProvider extends ServiceProvider
{
    /**
     * Register a service provider.
     */
    public function register()
    {
        $this->container[PubSubAdapterInterface::class] = function (ContainerInterface $container) {
            $config = $container->get('settings')['redis'];
            $client = new RedisClient($config);
            return new RedisPubSubAdapter($client);
        };

        $this->container[MessageTranslatorInterface::class] = function () {
            return new SchemaEventMessageTranslator();
        };

        $this->container[EventValidatorInterface::class] = function () {
            $dereferencer = new Dereferencer();
            return new JSONSchemaEventValidator($dereferencer);
        };

        $this->container[EventManager::class] = function (ContainerInterface $container) {
            $adapter = $container->get(PubSubAdapterInterface::class);
            $translator = $container->get(MessageTranslatorInterface::class);
            $validator = $container->get(EventValidatorInterface::class);
            $attributeInjectors = [
                new DateAttributeInjector(),
                new HostnameAttributeInjector(),
                new Uuid4AttributeInjector(),
                function () {
                    return [
                        'key' => 'service',
                        'value' => 'www',
                    ];
                }
            ];
            return new EventManager($adapter, $translator, $validator, $attributeInjectors);
        };
    }
}
