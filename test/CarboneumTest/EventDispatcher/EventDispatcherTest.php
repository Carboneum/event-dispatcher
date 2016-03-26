<?php

namespace CarboneumTest\EventDispatcher;

use Carboneum\EventDispatcher\EventDispatcher;
use Carboneum\EventDispatcher\Model\EventInterface;
use Carboneum\EventDispatcher\Model\Subscription;
use Carboneum\EventDispatcher\Service\InvokeAdapterInterface;
use Prophecy\Argument;
use Prophecy\Argument\Token\TypeToken;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;

class EventDispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param Subscription[] $subscriptionsConfig
     * @param EventInterface $event
     * @param array $expectedCalls
     *
     * @dataProvider provideTestDispatch
     */
    public function testDispatch(array $subscriptionsConfig, EventInterface $event, array $expectedCalls)
    {
        /** @var InvokeAdapterInterface|ObjectProphecy $invokeAdapter */
        $invokeAdapter = $this->prophesize(InvokeAdapterInterface::class);

        $invokerCalls = [];

        /** @var EventInterface|TypeToken $eventToken */
        $eventToken = Argument::type(EventInterface::class);
        /** @var MethodProphecy $method */
        $method = $invokeAdapter->invoke(Argument::type('string'), Argument::type('string'), $eventToken);
        $method->will(
            function ($args) use (&$invokerCalls) {
                list($serviceName, $methodName, $event) = $args;
                $invokerCalls[] = [$serviceName, $methodName, $event];
            }
        );

        $dispatcher = new EventDispatcher($invokeAdapter->reveal());
        $dispatcher->addConfig($subscriptionsConfig);

        $dispatcher->dispatch($event);

        $this->assertEquals($expectedCalls, $invokerCalls);
    }

    /**
     * @return array
     */
    public function provideTestDispatch()
    {
        $matchEvent = $this->getEventMockForName('matchEvent');

        return [
            [
                'subscriptionsConfig' => [
                    [
                        Subscription::EVENT_NAME => 'matchEvent',
                        Subscription::SERVICE_LOCATOR => 'service1',
                        Subscription::METHOD_NAME => 'method1'
                    ],
                    [
                        Subscription::EVENT_NAME => 'notMatchEvent',
                        Subscription::SERVICE_LOCATOR => 'service2',
                        Subscription::METHOD_NAME => 'method2'
                    ],
                    [
                        Subscription::EVENT_NAME => 'matchEvent',
                        Subscription::SERVICE_LOCATOR => 'service3',
                        Subscription::METHOD_NAME => 'method3',
                        Subscription::PRIORITY => 20
                    ],
                    [
                        Subscription::EVENT_NAME => 'matchEvent',
                        Subscription::SERVICE_LOCATOR => 'service4',
                        Subscription::METHOD_NAME => 'method4',
                        Subscription::PRIORITY => 10
                    ],
                ],
                'event' => $matchEvent,
                'expectedCalls' => [
                    ['service3', 'method3', $matchEvent],
                    ['service4', 'method4', $matchEvent],
                    ['service1', 'method1', $matchEvent],
                ]
            ]
        ];
    }

    /**
     * @param string $eventName
     * @return EventInterface|ObjectProphecy
     * @todo remove duplication
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
