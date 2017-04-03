<?php

namespace App\Services;

use App\Models\User;
use Superbalist\EventPubSub\EventManager;
use Superbalist\EventPubSub\Events\SchemaEvent;

class UserService
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
     * Create a new user.
     *
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $password
     * @return User
     */
    public function createUser($email, $firstName, $lastName, $password)
    {
        // create user account
        $user = new User([
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'password' => $password,
        ]);
        $user->save();

        // fire off 'user.created' event
        $event = new SchemaEvent(
            'http://php-meetup-pubsub.dev/schemas/events/user/created/1.0.json',
            [
                'user' => $user->toArray(),
            ]
        );
        $this->events->dispatch('events', $event);

        return $user;
    }

    /**
     * Authenticate a user by email and password.
     *
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public function auth($email, $password)
    {
        $user = User::findByEmail($email);
        if (!$user->checkPasswordHash($password)) {
            return null;
        }

        // fire off 'user.logged_in' event
        $event = new SchemaEvent(
            'http://php-meetup-pubsub.dev/schemas/events/user/logged_in/1.0.json',
            [
                'user' => $user->toArray(),
            ]
        );
        $this->events->dispatch('events', $event);

        return $user;
    }
}
