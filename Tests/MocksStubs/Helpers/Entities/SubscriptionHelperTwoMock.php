<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Helpers\Entities;

use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\SubscriptionHelper;

/**
 * Class SubscriptionHelperTwoMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Helpers\Entities
 */
class SubscriptionHelperTwoMock extends SubscriptionHelper
{
    /**
     * @param array $parameters
     * @return array
     */
    public function getSubscriptions(array $parameters = []): array
    {
        return [
            [
                EntityConstants::ID_FIELD_KEY => 1,
                EntityConstants::SEARCHABLE_FIELD_KEY => true,
                EntityConstants::PRICE_FIELD_KEY => 1
            ],
            [
                EntityConstants::ID_FIELD_KEY => 2,
                EntityConstants::SEARCHABLE_FIELD_KEY => true,
                EntityConstants::PRICE_FIELD_KEY => 2
            ]
        ];
    }

}