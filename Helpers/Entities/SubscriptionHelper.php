<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\SubscriptionApiService;
use Comitium5\ApiClientBundle\ValueObject\ParametersValue;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use Exception;

/**
 * Class SubscriptionHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class SubscriptionHelper
{
    /**
     * @var SubscriptionApiService
     */
    private $service;

    /**
     * @param Client $api
     */
    public function __construct(Client $api)
    {
        $factory = new ApiServiceFactory($api);
        $this->service = $factory->createSubscriptionApiService();
    }

    /**
     * @return SubscriptionApiService
     */
    public function getService(): SubscriptionApiService
    {
        return $this->service;
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws Exception
     */
    public function getSubscriptions(array $parameters = []): array
    {
        $results = $this->service->findBy(new ParametersValue($parameters));

        return ApiResultsHelper::extractResults($results);
    }

    /**
     * @return array|mixed
     * @throws Exception
     */
    public function getFreeSubscription()
    {
        $subscriptions = $this->getSubscriptions();

        if (empty($subscriptions)) {
            return [];
        }

        $helper = new EntityHelper();

        foreach ($subscriptions as $subscription) {
            $price = $helper->getPrice($subscription);
            if (!$price) {
                return $subscription;
            }
        }

        return [];
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getFreeSubscriptionId(): int
    {
        $subscription = $this->getFreeSubscription();

        $helper = new EntityHelper();

        return $helper->getId($subscription);
    }
}