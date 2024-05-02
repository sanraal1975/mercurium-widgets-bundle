<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Services\SubscriptionApiService;
use Comitium5\ApiClientBundle\Tests\TestCase;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\SubscriptionHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Helpers\Entities\SubscriptionHelperMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Helpers\Entities\SubscriptionHelperTwoMock;
use Exception;
use TypeError;

/**
 * Class SubscriptionHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class SubscriptionHelperTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @var ClientMock
     */
    private $api;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);
        $this->testHelper = new TestHelper();

        $this->api = $this->testHelper->getApi();
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCounterErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new SubscriptionHelper();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     * @return void
     */
    public function testConstructThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new SubscriptionHelper($parameter);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "parameter" => 1,
            ],
            [
                "parameter" => null,
            ],
        ];
    }

    /**
     * @return void
     */
    public function testGetService()
    {
        $helper = new SubscriptionHelper($this->api);
        $service = $helper->getService();

        $this->assertInstanceOf(SubscriptionApiService::class, $service);
    }

    /**
     * @dataProvider getSubscriptionsThrowsTypeErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testGetSubscriptionsThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new SubscriptionHelper($this->api);
        $result = $helper->getSubscriptions($parameter);
    }

    /**
     * @return array
     */
    public function getSubscriptionsThrowsTypeErrorException(): array
    {
        return [
            [
                "parameter" => 1,
            ],
            [
                "parameter" => "1",
            ],
            [
                "parameter" => null,
            ]
        ];
    }

    /**
     * @dataProvider getSubscriptions
     *
     * @return void
     * @throws Exception
     */
    public function testGetSubscriptions($parameters, $expected)
    {
        $helper = new SubscriptionHelper($this->api);
        $result = $helper->getSubscriptions($parameters);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getSubscriptions(): array
    {
        return [
            [
                "parameters" => [],
                "expected" => [
                    0 => [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        EntityConstants::PRICE_FIELD_KEY => 1
                    ],
                    1 => [
                        EntityConstants::ID_FIELD_KEY => 2,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        EntityConstants::PRICE_FIELD_KEY => 0
                    ]
                ]
            ],
            [
                "parameters" => ['empty' => true],
                "expected" => []
            ]
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetFreeSubscriptionNoSubscriptions()
    {
        $helper = new SubscriptionHelperMock($this->api);
        $result = $helper->getFreeSubscription();
        $expected = [];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetFreeSubscriptionNoFreeSubscriptions()
    {
        $helper = new SubscriptionHelperTwoMock($this->api);
        $result = $helper->getFreeSubscription();
        $expected = [];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetFreeSubscription()
    {
        $helper = new SubscriptionHelper($this->api);
        $result = $helper->getFreeSubscription();

        $expected = [
            EntityConstants::ID_FIELD_KEY => 2,
            EntityConstants::SEARCHABLE_FIELD_KEY => true,
            EntityConstants::PRICE_FIELD_KEY => 0
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetFreeSubscriptionId()
    {
        $helper = new SubscriptionHelper($this->api);
        $result = $helper->getFreeSubscriptionId();
        $expected = 2;

        $this->assertEquals($expected, $result);
    }
}