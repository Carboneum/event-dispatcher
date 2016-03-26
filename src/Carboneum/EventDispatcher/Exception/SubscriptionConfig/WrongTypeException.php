<?php

namespace Carboneum\EventDispatcher\Exception\SubscriptionConfig;

use Carboneum\EventDispatcher\Exception\EventDispatcherException;

/**
 * Class WrongTypeException
 * @package Carboneum\EventDispatcher
 */
class WrongTypeException extends EventDispatcherException
{
    const CODE = self::ERROR_CODE_WRONG_TYPE;
    const MESSAGE = 'Value of a key {key_name} expected to be a {expected_type}, {actual_type} given';

    const KEY_NAME = 'key_name';
    const EXPECTED_TYPE = 'expected_type';
    const ACTUAL_TYPE = 'actual_type';

    /**
     * @param string $keyName
     * @param string $expectedType
     * @param string $actualType
     * @param \Exception|null $previous
     */
    public function __construct($keyName, $expectedType, $actualType, \Exception $previous = null)
    {
        $this->setContextValues(
            [
                self::KEY_NAME => $keyName,
                self::EXPECTED_TYPE => $expectedType,
                self::ACTUAL_TYPE => $actualType
            ]
        );
        parent::__construct($previous);
    }
}
