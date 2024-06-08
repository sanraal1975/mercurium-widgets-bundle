<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\UserHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class UserHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class UserHelperTest extends TestCase
{
    /**
     * @dataProvider getSubscriptionsReturnFalse
     *
     * @return void
     */
    public function testHasSubscriptionsReturnFalse(array $entity, $expected)
    {
        $helper = new UserHelper();
        $result = $helper->hasSubscriptions($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getSubscriptionsReturnFalse(): array
    {
        return [
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "expected" => false
            ],
        ];
    }

    /**
     * @dataProvider getSubscriptionsReturnTrue
     *
     * @return void
     */
    public function testHasSubscriptionsReturnTrue(array $entity, $expected)
    {
        $helper = new UserHelper();
        $result = $helper->hasSubscriptions($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getSubscriptionsReturnTrue(): array
    {
        return [
            [
                "entity" => [EntityConstants::SUBSCRIPTIONS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => 1]]],
                "expected" => true
            ],
        ];
    }

    /**
     * @dataProvider getActiveSubscriptionReturnFalse
     *
     * @return void
     */
    public function testActiveSubscriptionReturnFalse(array $entity)
    {
        $helper = new UserHelper();
        $result = $helper->hasActiveSubscription($entity);

        $this->assertFalse($result);
    }

    /**
     * @return array[]
     */
    public function getActiveSubscriptionReturnFalse(): array
    {
        return [
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
            ],
            [
                "entity" => [EntityConstants::SUBSCRIPTIONS_FIELD_KEY => [[EntityConstants::EXPIRATION_DATE_FIELD_KEY => "2010-01-01"]]],
            ],
        ];
    }

    /**
     * @dataProvider getActiveSubscriptionReturnTrue
     *
     * @return void
     */
    public function testActiveSubscriptionReturnTrue(array $entity)
    {
        $helper = new UserHelper();
        $result = $helper->hasActiveSubscription($entity);

        $this->assertTrue($result);
    }

    /**
     * @return array[]
     */
    public function getActiveSubscriptionReturnTrue(): array
    {
        return [
            [
                "entity" => [EntityConstants::SUBSCRIPTIONS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => 1,]]],
            ],
            [
                "entity" => [EntityConstants::SUBSCRIPTIONS_FIELD_KEY => [[EntityConstants::EXPIRATION_DATE_FIELD_KEY => "3010-01-01"]]],
            ],
        ];
    }

    /**
     * @dataProvider getActivePaymentSubscriptionReturnFalse
     *
     * @return void
     */
    public function testActivePaymentSubscriptionReturnFalse(array $entity)
    {
        $helper = new UserHelper();
        $result = $helper->hasActivePaymentSubscription($entity);

        $this->assertFalse($result);
    }

    /**
     * @return array[]
     */
    public function getActivePaymentSubscriptionReturnFalse(): array
    {
        return [
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
            ],
            [
                "entity" => [EntityConstants::SUBSCRIPTIONS_FIELD_KEY => [[EntityConstants::EXPIRATION_DATE_FIELD_KEY => "2010-01-01"]]],
            ],
            [
                "entity" => [EntityConstants::SUBSCRIPTIONS_FIELD_KEY => [[EntityConstants::PRICE_FIELD_KEY => 1, EntityConstants::EXPIRATION_DATE_FIELD_KEY => "2010-01-01"]]],
            ],
        ];
    }

    /**
     * @dataProvider getActivePaymentSubscriptionReturnTrue
     *
     * @return void
     */
    public function testActivePaymentSubscriptionReturnTrue(array $entity)
    {
        $helper = new UserHelper();
        $result = $helper->hasActivePaymentSubscription($entity);

        $this->assertTrue($result);
    }

    /**
     * @return array[]
     */
    public function getActivePaymentSubscriptionReturnTrue(): array
    {
        return [
            [
                "entity" => [EntityConstants::SUBSCRIPTIONS_FIELD_KEY => [[EntityConstants::PRICE_FIELD_KEY => 1]]],
            ],
            [
                "entity" => [EntityConstants::SUBSCRIPTIONS_FIELD_KEY => [[EntityConstants::PRICE_FIELD_KEY => 1, EntityConstants::EXPIRATION_DATE_FIELD_KEY => "3000-01-01"]]],
            ],
        ];
    }
}