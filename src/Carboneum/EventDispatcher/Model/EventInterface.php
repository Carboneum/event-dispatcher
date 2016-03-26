<?php

namespace Carboneum\EventDispatcher\Model;

/**
 * Interface EventInterface
 * @package Carboneum\EventDispatcher
 */
interface EventInterface
{
    /**
     * @return string
     */
    public function getEventName();
}
