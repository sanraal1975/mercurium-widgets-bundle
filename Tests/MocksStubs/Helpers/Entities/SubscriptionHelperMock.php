<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Helpers\Entities;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\SubscriptionHelper;

/**
 * Class SubscriptionHelperMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Helpers\Entities
 */
class SubscriptionHelperMock extends SubscriptionHelper
{
    /**
     * @param array $parameters
     * @return array
     */
    public function getSubscriptions(array $parameters = []): array
    {
        return [];
    }
}