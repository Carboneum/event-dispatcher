<?php

namespace Carboneum\EventDispatcher\Service;

use Carboneum\EventDispatcher\Exception\SubscriptionConfig;
use Carboneum\EventDispatcher\Model\Subscription;

/**
 * Class SubscriptionFactory
 * @package Carboneum\EventDispatcher
 */
class SubscriptionFactory
{
    /**
     * @param array $subscriptionConfig
     *
     * @throws SubscriptionConfig\MissingKeyException
     * @throws SubscriptionConfig\WrongTypeException
     *
     * @return Subscription
     */
    public function create(array $subscriptionConfig)
    {
        $this->validateSubscription($subscriptionConfig);

        return new Subscription(
            $subscriptionConfig[Subscription::EVENT_NAME],
            $subscriptionConfig[Subscription::SERVICE_LOCATOR],
            $subscriptionConfig[Subscription::METHOD_NAME],
            $this->getPriority($subscriptionConfig)
        );
    }

    /**
     * @param array $subscriptionsConfig
     *
     * @return Subscription[]
     */
    public function createList(array $subscriptionsConfig)
    {
        return array_map([$this, 'create'], $subscriptionsConfig);
    }

    /**
     * @param array $subscriptionConfig
     * @return array
     * @throws SubscriptionConfig\WrongTypeException
     */
    private function getPriority(array $subscriptionConfig)
    {
        $priority = 0;
        if (isset($subscriptionConfig[Subscription::PRIORITY])) {
            $priority = $subscriptionConfig[Subscription::PRIORITY];
        }

        if (!is_int($priority)) {
            throw new SubscriptionConfig\WrongTypeException(Subscription::PRIORITY, 'int', gettype($priority));
        }

        return $priority;
    }

    /**
     * @param array $subscriptionConfig
     *
     * @throws SubscriptionConfig\MissingKeyException
     * @throws SubscriptionConfig\WrongTypeException
     */
    private function validateSubscription(array $subscriptionConfig)
    {
        foreach ([Subscription::EVENT_NAME, Subscription::SERVICE_LOCATOR, Subscription::METHOD_NAME] as $key) {
            if (!isset($subscriptionConfig[$key])) {
                throw new SubscriptionConfig\MissingKeyException($key);
            }

            if (!is_string($subscriptionConfig[$key])) {
                throw new SubscriptionConfig\WrongTypeException($key, 'string', gettype($subscriptionConfig[$key]));
            }
        }
    }
}
