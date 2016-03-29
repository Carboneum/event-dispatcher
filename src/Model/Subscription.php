<?php

namespace Carboneum\EventDispatcher\Model;

/**
 * Class Subscription
 * @package Carboneum\EventDispatcher
 */
class Subscription
{
    const EVENT_NAME = 'event_name';
    const SERVICE_LOCATOR = 'service_locator';
    const METHOD_NAME = 'method_name';
    const PRIORITY = 'priority';

    /** @var string */
    protected $eventName;

    /** @var string */
    protected $serviceLocator;

    /** @var string */
    protected $methodName;

    /** @var int */
    protected $priority;

    /**
     * @param string $eventName
     * @param string $serviceLocator
     * @param string $methodName
     * @param int $priority
     */
    public function __construct($eventName, $serviceLocator, $methodName, $priority = 0)
    {
        $this->eventName = $eventName;
        $this->serviceLocator = $serviceLocator;
        $this->methodName = $methodName;
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @return string
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
