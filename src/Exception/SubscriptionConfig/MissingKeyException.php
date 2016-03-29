<?php

namespace Carboneum\EventDispatcher\Exception\SubscriptionConfig;

use Carboneum\EventDispatcher\Exception\EventDispatcherException;

/**
 * Class MissingKeyException
 * @package Carboneum\EventDispatcher
 */
class MissingKeyException extends EventDispatcherException
{
    const CODE = self::ERROR_CODE_MISSING_KEY;
    const MESSAGE = 'Key {key_name} is missing for subscription config';

    const KEY_NAME = 'key_name';

    /**
     * @param string $keyName
     * @param \Exception|null $previous
     */
    public function __construct($keyName, \Exception $previous = null)
    {
        $this->setContextValue(self::KEY_NAME, $keyName);
        parent::__construct($previous);
    }
}
