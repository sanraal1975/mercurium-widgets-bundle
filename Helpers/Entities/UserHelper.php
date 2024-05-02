<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\ValueObject\ParametersValue;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use DateTime;

/**
 * Class UserHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class UserHelper
{
    /**
     * @param array $userData
     *
     * @return bool
     */
    public function hasSubscriptions(array $userData): bool
    {
        $helper = new EntityHelper();
        $subscriptions = $helper->getSubscriptions($userData);
        
        return !empty($subscriptions);
    }

    /**
     * @param array $userData
     *
     * @return bool
     */
    public function hasActiveSubscription(array $userData): bool
    {
        if (!$this->hasSubscriptions($userData)) {
            return false;
        }

        $now = new DateTime();
        $nowString = $now->format("Y-m-d H:i:s");

        $helper = new EntityHelper();
        $subscriptions = $helper->getSubscriptions($userData);

        foreach ($subscriptions as $subscription) {
            $expirationDate = $helper->getExpirationDate($subscription);
            if (empty($expirationDate)) {
                return true;
            }
            if ($nowString < $expirationDate) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $userData
     *
     * @return bool
     */
    public function hasActivePaymentSubscription(array $userData): bool
    {
        if (!$this->hasSubscriptions($userData)) {
            return false;
        }

        $now = new DateTime();
        $nowString = $now->format("Y-m-d H:i:s");

        $helper = new EntityHelper();
        $subscriptions = $helper->getSubscriptions($userData);

        foreach ($subscriptions as $subscription) {
            $expirationDate = $helper->getExpirationDate($subscription);
            $price = $helper->getPrice($subscription);
            if ($price > 0) {
                if (empty($expirationDate)) {
                    return true;
                }
                if ($nowString < $expirationDate) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param Client $api
     * @param int $userId
     * @param int $subscriptionId
     *
     * @return array
     */
    public function addSubscription(Client $api, int $userId, int $subscriptionId): array
    {
        $factory = new ApiServiceFactory($api);
        $service = $factory->createContactSubscriptionApiService();

        return $service->post(
            new ParametersValue(
                [
                    "contact" => $userId,
                    "subscription" => $subscriptionId,
                ]
            )
        );
    }
}