<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\ContactSubscriptionApiService;
use Comitium5\ApiClientBundle\ValueObject\ParametersValue;
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
        return !empty($userData['subscriptions']);
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

        foreach ($userData['subscriptions'] as $subscription) {
            if (empty($subscription['expirationDate'])) {
                return true;
            }
            if ($nowString < $subscription['expirationDate']) {
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

        foreach ($userData['subscriptions'] as $subscription) {
            if (empty($subscription['expirationDate'])) {
                continue;
            }
            if ($nowString < $subscription['expirationDate']) {
                return true;
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
        $service = new ContactSubscriptionApiService($api);

        return $service->post(
            new ParametersValue(
                [
                    "contact"      => $userId,
                    "subscription" => $subscriptionId,
                ]
            )
        );
    }
}