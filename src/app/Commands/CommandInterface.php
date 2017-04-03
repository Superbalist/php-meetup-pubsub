<?php

namespace App\Commands;

interface CommandInterface
{
    /**
     * @param array $options
     */
    public function run(array $options = []);
}
