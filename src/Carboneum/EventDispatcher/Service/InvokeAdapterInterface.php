<?php

namespace Carboneum\EventDispatcher\Service;

use Carboneum\EventDispatcher\Model\EventInterface;

/**
 * Interface InvokeAdapterInterface
 */
interface InvokeAdapterInterface
{
    /**
     * Implementation of this method should handle all architecture-specific work:
     *  - Loading module, and locating/constructing service
     *  - Calling service method and passing event object to it
     *
     * @param string $service
     * @param string  $method
     * @param EventInterface $event
     *
     * @return null
     */
    public function invoke($service, $method, EventInterface $event);
}
