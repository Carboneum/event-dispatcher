<?php

namespace CarboneumTest\EventDispatcher\Model;

use Carboneum\EventDispatcher\Model\Subscription;
use Carboneum\EventDispatcher\Service\SubscriptionFactory;

/**
 * Class SubscriptionFactoryTest
 */
class SubscriptionFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $config
     * @param string $serviceLocator
     * @param string $methodName
     * @param string $eventName
     * @param int $priority
     *
     * @dataProvider provideTestCreateSuccess
     */
    public function testCreateSuccess(array $config, $serviceLocator, $methodName, $eventName, $priority)
    {
        $factory = new SubscriptionFactory();
        $subscription = $factory->create($config);

        $this->assertEquals($serviceLocator, $subscription->getServiceLocator());
        $this->assertEquals($methodName, $subscription->getMethodName());
        $this->assertEquals($eventName, $subscription->getEventName());
        $this->assertEquals($priority, $subscription->getPriority());
    }

    /**
     * @return array
     */
    public function provideTestCreateSuccess()
    {
        return [

            'full specification' => [
                'config' => [
                    Subscription::METHOD_NAME => 'methodName',
                    Subscription::SERVICE_LOCATOR => 'serviceLocator',
                    Subscription::EVENT_NAME => 'eventName',
                    Subscription::PRIORITY => 10
                ],
                'service' => 'serviceLocator',
                'method' => 'methodName',
                'event' => 'eventName',
                'priority' => 10,
            ],

            'wrong order' => [
                'config' => [
                    Subscription::PRIORITY => 10,
                    Subscription::SERVICE_LOCATOR => 'serviceLocator',
                    Subscription::METHOD_NAME => 'methodName',
                    Subscription::EVENT_NAME => 'eventName'
                ],
                'service' => 'serviceLocator',
                'method' => 'methodName',
                'event' => 'eventName',
                'priority' => 10,
            ],

            'default priority' => [
                'config' => [
                    Subscription::SERVICE_LOCATOR => 'serviceLocator',
                    Subscription::METHOD_NAME => 'methodName',
                    Subscription::EVENT_NAME => 'eventName'
                ],
                'service' => 'serviceLocator',
                'method' => 'methodName',
                'event' => 'eventName',
                'priority' => 0,
            ]
        ];
    }

    /**
     * @param array $config
     *
     * @expectedException \Carboneum\EventDispatcher\Exception\SubscriptionConfig\MissingKeyException
     *
     * @dataProvider provideTestCreateMissingKeyException
     */
    public function testCreateMissingKeyException(array $config)
    {
        $factory = new SubscriptionFactory();
        $factory->create($config);
    }

    /**
     * @return array
     */
    public function provideTestCreateMissingKeyException()
    {
        return [
            'missing key methodName' => [
                'config' => [
                    Subscription::SERVICE_LOCATOR => 'serviceLocator',
                    Subscription::EVENT_NAME => 'eventName'
                ],
            ],

            'missing key eventName' => [
                'config' => [
                    Subscription::SERVICE_LOCATOR => 'serviceLocator',
                    Subscription::METHOD_NAME => 'methodName',
                ],
            ],

            'missing key serviceLocator' => [
                'config' => [
                    Subscription::METHOD_NAME => 'methodName',
                    Subscription::EVENT_NAME => 'eventName'
                ],
            ],

        ];
    }

    /**
     * @param array $config
     *
     * @expectedException \Carboneum\EventDispatcher\Exception\SubscriptionConfig\WrongTypeException
     *
     * @dataProvider provideTestCreateWrongTypeException
     */
    public function testCreateWrongTypeException(array $config)
    {
        $factory = new SubscriptionFactory();
        $factory->create($config);
    }

    public function provideTestCreateWrongTypeException()
    {
        return [
            'wrong type serviceLocator' => [
                'config' => [
                    Subscription::SERVICE_LOCATOR => ['serviceLocator'],
                    Subscription::METHOD_NAME => 'methodName',
                    Subscription::EVENT_NAME => 'eventName'
                ],
            ],

            'wrong type methodName' => [
                'config' => [
                    Subscription::SERVICE_LOCATOR => 'serviceLocator',
                    Subscription::METHOD_NAME => new \stdClass(),
                    Subscription::EVENT_NAME => 'eventName'
                ],
            ],

            'wrong type eventName' => [
                'config' => [
                    Subscription::SERVICE_LOCATOR => 'serviceLocator',
                    Subscription::METHOD_NAME => 'methodName',
                    Subscription::EVENT_NAME => 100
                ],
            ],

            'wrong type priority' => [
                'config' => [
                    Subscription::SERVICE_LOCATOR => 'serviceLocator',
                    Subscription::METHOD_NAME => 'methodName',
                    Subscription::EVENT_NAME => 'eventName',
                    Subscription::PRIORITY => [],
                ],
            ],
        ];
    }

    /**
     * @param array $listConfig
     * @param Subscription[] $expectedSubscriptionList
     *
     * @dataProvider provideTestCreateList
     */
    public function testCreateList(array $listConfig, array $expectedSubscriptionList)
    {
        $factory = new SubscriptionFactory();
        $subscriptionList = $factory->createList($listConfig);

        $this->assertEquals($expectedSubscriptionList, $subscriptionList);
    }

    /**
     * @return array
     */
    public function provideTestCreateList()
    {
        return [
            'empty list' => [
                'listConfig' => [],
                'expectedSubscriptionList' => [],
            ],

            'two item list' => [
                'listConfig' => [
                    [
                        Subscription::SERVICE_LOCATOR => 'serviceLocatorOne',
                        Subscription::METHOD_NAME => 'methodNameOne',
                        Subscription::EVENT_NAME => 'eventNameOne',
                        Subscription::PRIORITY => 10,
                    ],
                    [
                        Subscription::SERVICE_LOCATOR => 'serviceLocatorTwo',
                        Subscription::METHOD_NAME => 'methodNameTwo',
                        Subscription::EVENT_NAME => 'eventNameTwo',
                        Subscription::PRIORITY => 20,
                    ],
                ],
                'expectedSubscriptionList' => [
                    new Subscription('eventNameOne', 'serviceLocatorOne', 'methodNameOne', 10),
                    new Subscription('eventNameTwo', 'serviceLocatorTwo', 'methodNameTwo', 20),
                ],
            ]
        ];
    }
}
