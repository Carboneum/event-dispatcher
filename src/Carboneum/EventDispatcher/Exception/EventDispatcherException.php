<?php

namespace Carboneum\EventDispatcher\Exception;

use Carboneum\ContextualException\Exception;

/**
 * Class EventDispatcherException
 * @package Carboneum\EventDispatcher
 */
class EventDispatcherException extends Exception
{
    const CODE_PACKAGE_PREFIX = 103000;
    const CODE = 0;

    const MESSAGE = 'EventDispatcher exception. Context: {exception_contexts}';


    const ERROR_CODE_MISSING_KEY = 1;
    const ERROR_CODE_WRONG_TYPE = 2;
}
