<?php

namespace App\Supports\Services;

use Facebook\PersistentData\PersistentDataInterface;

class FacebookLoginPersistentDataService implements PersistentDataInterface
{
    /**
     * @var string Prefix to use for session variables.
     */
    protected $sessionPrefix = 'FBRLH_';

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        return session()->get($this->sessionPrefix . $key);
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value)
    {
        session()->put($this->sessionPrefix . $key, $value);
    }
}
