# php-meetup-pubsub

A demo showcasing Pub/Sub in PHP for the meetup event []http://meetup.com/Cape-Town-PHP-Group/events/238490899/]

The demo is built using:
* [Slim Framework](https://www.slimframework.com)
* [Bootstrap](http://getbootstrap.com)
* [superbalist/php-event-pubsub package](https://github.com/Superbalist/php-event-pubsub)
* [superbalist/php-pubsub-redis package](https://github.com/Superbalist/php-pubsub-redis)

## Running

The demo runs using docker and docker-compose.

It is assumed that you already have a docker environment setup on your local machine.

If you're new to docker, have a look at [https://docs.docker.com/engine/installation/]

```bash
make up
```

## Running Commands

```bash
make bash

php cmd.php listen-all-raw-messages-on-events-channel
php cmd.php listen-all-events
php cmd.php listen-all-user-topic-events
php cmd.php listen-all-user-created-events
php cmd.php listen-all-user-created-v1-events
php cmd.php listen-all-user-created-v2-events
php cmd.php fire-event-with-missing-schema
```

## Stopping

```bash
make down
```

## Further Reading

* https://github.com/Superbalist/php-pubsub
* https://github.com/Superbalist/php-pubsub-redis
* https://github.com/Superbalist/php-pubsub-kafka
* https://github.com/Superbalist/php-pubsub-google-cloud
* https://github.com/Superbalist/laravel-pubsub
* https://github.com/Superbalist/laravel4-pubsub
* https://github.com/Superbalist/php-event-pubsub
* https://github.com/Superbalist/laravel-event-pubsub
* https://github.com/Superbalist/laravel4-event-pubsub
