<?php

namespace App\Models;

use Faker\Factory as FakerFactory;

class User extends BaseModel
{
    // stub class for a user model

    /**
     * @param string $password
     * @return bool
     */
    public function checkPasswordHash($password)
    {
        // in the real world, we'd compare the user's password on file to a bcrypt hash of the plain-text password
        return true;
    }

    /**
     * @param string $email
     * @return User
     */
    public static function findByEmail($email)
    {
        $faker = FakerFactory::create();
        return new User([
            'id' => rand(1, 9999),
            'email' => $email,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
        ]);
    }
}
