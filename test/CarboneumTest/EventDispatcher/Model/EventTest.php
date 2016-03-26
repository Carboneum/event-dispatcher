<?php

namespace CarboneumTest\EventDispatcher\Model;

use Carboneum\EventDispatcher\Model\EventInterface;
use CarboneumTest\EventDispatcher\Model\EventTest\EventMock;

class EventTest extends \PHPUnit_Framework_TestCase
{
    public function testEvent()
    {
        $event = new EventMock();

        $this->assertInstanceOf(EventInterface::class, $event);
        $this->assertEquals(EventMock::class, $event->getEventName());
    }

}
