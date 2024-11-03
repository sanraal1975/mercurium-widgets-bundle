<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\SubscriptionApiService;
use Comitium5\ApiClientBundle\ValueObject\IdentifiedValue;
use Comitium5\ApiClientBundle\ValueObject\ParametersValue;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use Comitium5\MercuriumWidgetsBundle\Interfaces\EntityGetByInterface;
use Comitium5\MercuriumWidgetsBundle\Interfaces\EntityGetInterface;
use Comitium5\MercuriumWidgetsBundle\Interfaces\EntityGetServiceInterface;
use Exception;

/**
 * Class SubscriptionHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class SubscriptionHelper implements EntityGetServiceInterface, EntityGetInterface, EntityGetByInterface
{
    const ENTITY_ID_MUST_BE_GREATER_THAN_ZERO = "SubscriptionHelper::get. entityId must be greater than 0";

    /**
     * @var SubscriptionApiService
     */
    private SubscriptionApiService $service;

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
     * @param int $entityId
     *
     * @return array
     * @throws Exception
     */
    public function get(int $entityId): array
    {
        if ($entityId < 1) {
            throw new Exception(self::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);
        }

        return $this->service->find(new IdentifiedValue($entityId));
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws Exception
     */
    public function getBy(array $parameters): array
    {
        return $this->service->findBy(
            new ParametersValue($parameters)
        );
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws Exception
     */
    public function getSubscriptions(array $parameters = []): array
    {
        $results = $this->getBy($parameters);

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