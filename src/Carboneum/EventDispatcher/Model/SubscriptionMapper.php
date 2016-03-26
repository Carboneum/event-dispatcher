<?php

namespace Carboneum\EventDispatcher\Model;

/**
 * Class SubscriptionMapper
 * @package Carboneum\EventDispatcher
 */
class SubscriptionMapper
{
    /**
     * @var  Subscription[string][int][] Subscription list indexed by eventName and priority
     */
    protected $subscriptions = [];

    /**
     * @param EventInterface $event
     *
     * @return \Generator|Subscription[]
     */
    public function getSubscriptionsForEvent(EventInterface $event)
    {
        if (isset($this->subscriptions[$event->getEventName()])) {
            foreach ($this->subscriptions[$event->getEventName()] as $priority => $subscriptions) {
                /** @var Subscription $subscription */
                foreach ($subscriptions as $subscription) {
                    yield $subscription;
                }
            }
        }
    }

    /**
     * @param Subscription $subscription
     */
    public function addSubscription(Subscription $subscription)
    {
        $this->subscriptions[$subscription->getEventName()][$subscription->getPriority()][] = $subscription;
        krsort($this->subscriptions[$subscription->getEventName()]);
    }

    /**
     * @param Subscription[] $subscriptions
     */
    public function addSubscriptionList(array $subscriptions)
    {
        $resort = [];
        foreach ($subscriptions as $subscription) {
            $this->subscriptions[$subscription->getEventName()][$subscription->getPriority()][] = $subscription;
            $resort[$subscription->getEventName()] = true;
        }

        foreach (array_keys($resort) as $eventName) {
            krsort($this->subscriptions[$eventName]);
        }
    }

}
