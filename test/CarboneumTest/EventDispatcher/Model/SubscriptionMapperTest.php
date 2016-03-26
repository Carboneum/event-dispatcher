<?php

namespace CarboneumTest\EventDispatcher\Model;

use Carboneum\EventDispatcher\Model\EventInterface;
use Carboneum\EventDispatcher\Model\Subscription;
use Carboneum\EventDispatcher\Model\SubscriptionMapper;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;

class SubscriptionMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests adding single subscription
     */
    public function testAddSubscription()
    {
        $mapper = new SubscriptionMapper();

        $subscription = new Subscription('event', 'service', 'method', 10);
        $mapper->addSubscription($subscription);

        $event = $this->getEventMockForName('event');

        $subscriptions = [];
        foreach ($mapper->getSubscriptionsForEvent($event) as $subscription) {
            $subscriptions[] = $subscription;
        }

        $this->assertEquals([$subscription], $subscriptions);
    }

    /**
     * @param Subscription[] $subscriptions
     * @param string $eventName
     * @param Subscription[] $expectedSubscriptions
     *
     * @dataProvider provideTestAddSubscriptionList
     */
    public function testAddSubscriptionList(array $subscriptions, $eventName, array $expectedSubscriptions)
    {
        $mapper = new SubscriptionMapper();

        $mapper->addSubscriptionList($subscriptions);
        $event = $this->getEventMockForName($eventName);

        $subscriptions = [];
        foreach ($mapper->getSubscriptionsForEvent($event) as $subscription) {
            $subscriptions[] = $subscription;
        }

        $this->assertEquals($expectedSubscriptions, $subscriptions);

    }

    /**
     * @return array
     */
    public function provideTestAddSubscriptionList()
    {
        return [
            'matching event' => [
                'subscriptions' => [
                    new Subscription('matchingEvent', 'service1', 'method1'),
                    new Subscription('notMatchingEvent', 'service2', 'method2'),
                    new Subscription('matchingEvent', 'service3', 'method3'),
                ],
                'eventName' => 'matchingEvent',
                'expectedSubscriptions' => [
                    new Subscription('matchingEvent', 'service1', 'method1'),
                    new Subscription('matchingEvent', 'service3', 'method3'),
                ]
            ],
            'event priority' => [
                'subscriptions' => [
                    new Subscription('matchingEvent', 'service1', 'method1'),
                    new Subscription('notMatchingEvent', 'service2', 'method2'),
                    new Subscription('matchingEvent', 'service3', 'method3', 10),
                ],
                'eventName' => 'matchingEvent',
                'expectedSubscriptions' => [
                    new Subscription('matchingEvent', 'service3', 'method3', 10),
                    new Subscription('matchingEvent', 'service1', 'method1'),
                ]
            ],

            'empty matching event' => [
                'subscriptions' => [
                    new Subscription('notMatchingEventOne', 'service1', 'method1'),
                    new Subscription('notMatchingEvent', 'service2', 'method2'),
                ],
                'eventName' => 'matchingEvent',
                'expectedSubscriptions' => []
            ],
        ];
    }

    /**
     * @return EventInterface|ObjectProphecy
     */
    protected function getEventMockForName($eventName)
    {
        /** @var EventInterface|ObjectProphecy $event */
        $event = $this->prophesize(EventInterface::class);

        /** @var MethodProphecy $method */
        $method = $event->getEventName();
        $method->willReturn($eventName);

        return $event->reveal();
    }
}
