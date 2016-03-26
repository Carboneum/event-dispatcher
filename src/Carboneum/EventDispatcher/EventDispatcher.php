<?php

namespace Carboneum\EventDispatcher;

use Carboneum\EventDispatcher\Model\EventInterface;
use Carboneum\EventDispatcher\Model\SubscriptionMapper;
use Carboneum\EventDispatcher\Service\InvokeAdapterInterface;
use Carboneum\EventDispatcher\Service\SubscriptionFactory;

/**
 * Class EventDispatcher
 * @package Carboneum\EventDispatcher
 */
class EventDispatcher
{
    /**
     * @var InvokeAdapterInterface
     */
    protected $invokeAdapter;

    /**
     * @var SubscriptionMapper
     */
    protected $subscriptionMapper;

    /**
     * @var SubscriptionFactory
     */
    protected $subscriptionFactory;

    /**
     * @param InvokeAdapterInterface $invokeAdapter
     * @param SubscriptionMapper $subscriptionMapper
     * @param SubscriptionFactory $subscriptionFactory
     */
    public function __construct(
        InvokeAdapterInterface $invokeAdapter,
        SubscriptionMapper $subscriptionMapper = null,
        SubscriptionFactory $subscriptionFactory = null
    ) {
        $this->invokeAdapter = $invokeAdapter;
        $this->subscriptionMapper = null === $subscriptionMapper ? new SubscriptionMapper() : $subscriptionMapper;
        $this->subscriptionFactory = null === $subscriptionFactory ? new SubscriptionFactory() : $subscriptionFactory;
    }

    /**
     * @param EventInterface $event
     */
    public function dispatch(EventInterface $event)
    {
        foreach ($this->subscriptionMapper->getSubscriptionsForEvent($event) as $subscription) {
            $this->invokeAdapter->invoke($subscription->getServiceLocator(), $subscription->getMethodName(), $event);
        }
    }

    /**
     * @param array $subscriptionsConfig
     */
    public function addConfig(array $subscriptionsConfig)
    {
        $this->subscriptionMapper->addSubscriptionList(
            $this->subscriptionFactory->createList($subscriptionsConfig)
        );
    }
}
