<?php

namespace Carboneum\EventDispatcher\Model;

/**
 * Class Event
 * @package Carboneum\EventDispatcher
 */
abstract class Event implements EventInterface
{
    /**
     * @return string
     */
    public function getEventName()
    {
        return static::class;
    }
}
