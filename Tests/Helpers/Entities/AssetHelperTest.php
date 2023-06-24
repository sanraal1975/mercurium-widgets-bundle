<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AssetApiService;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AssetHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class AssetHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class AssetHelperTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->testHelper = new TestHelper();
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new AssetHelper();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @return void
     */
    public function testConstructThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new AssetHelper($parameter);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "parameter" => $this->testHelper->getPositiveValue(),
            ],
            [
                "parameter" => null,
            ],
        ];
    }

    /**
     *
     * @return void
     */
    public function testGetService()
    {
        $helper = new AssetHelper($this->testHelper->getApi());

        $service = $helper->getService();

        $this->assertInstanceOf(AssetApiService::class, $service);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new AssetHelper($this->testHelper->getApi());
        $result = $helper->get();
    }

    /**
     * @dataProvider getThrowsTypeErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testGetThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new AssetHelper($this->testHelper->getApi());
        $result = $helper->get($parameter);
    }

    /**
     * @return array
     */
    public function getThrowsTypeErrorException(): array
    {
        return [
            [
                "parameter" => "",
            ],
            [
                "parameter" => null,
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetThrowsExceptionMessageEntityIdGreaterThanZero()
    {
        $this->expectExceptionMessage(AssetHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AssetHelper($this->testHelper->getApi());
        $helper->get($this->testHelper->getZeroOrNegativeValue());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByIdsThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new AssetHelper($this->testHelper->getApi());
        $result = $helper->getByIds();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByIdsThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new AssetHelper($this->testHelper->getApi());
        $helper->getByIds(null);
    }

    /**
     * @dataProvider getByIdsThrowsExceptionMessageEntityIdGreaterThanZero
     *
     * @param string $parameter
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsThrowsExceptionMessageEntityIdGreaterThanZero(string $parameter)
    {
        $this->expectExceptionMessage(AssetHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AssetHelper($this->testHelper->getApi());
        $result = $helper->getByIds($parameter);
    }

    /**
     * @return array[]
     */
    public function getByIdsThrowsExceptionMessageEntityIdGreaterThanZero(): array
    {
        return [
            [
                "parameter" => $this->testHelper->getZeroOrNegativeValueAsString(),
            ],
            [
                "parameter" => $this->testHelper->getPositiveValueAndZeroOrNegativeValueAsString(),
            ],
            [
                "parameter" => $this->testHelper->getPositiveValueAndNullValueAsString(),
            ],
        ];
    }

    /**
     * @dataProvider getByIdsReturnEmpty
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsReturnEmpty(string $ids)
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new AssetHelper($this->testHelper->getApi());
        $result = $helper->getByIds($ids);

        $this->assertEquals([], $result);
    }

    /**
     * @return array[]
     */
    public function getByIdsReturnEmpty(): array
    {
        return [
            [
                "ids" => ""
            ],
            [
                "ids" => "0"
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new AssetHelper($this->testHelper->getApi());
        $result = $helper->getByIdsAndQuantity();
    }

    /**
     * @dataProvider getByIdsAndQuantityThrowsTypeErrorException
     *
     * @param $entitiesIds
     * @param $quantity
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityThrowsTypeErrorException($entitiesIds, $quantity)
    {
        $this->expectException(TypeError::class);

        $helper = new AssetHelper($this->testHelper->getApi());
        $result = $helper->getByIdsAndQuantity($entitiesIds, $quantity);
    }

    /**
     * @return array
     */
    public function getByIdsAndQuantityThrowsTypeErrorException(): array
    {
        return [
            [
                "entitiesIds" => null,
                "quantity" => $this->testHelper->getPositiveValue(),
            ],
            [
                "entitiesIds" => $this->testHelper->getPositiveValueAsString(),
                "quantity" => "",
            ],
            [
                "entitiesIds" => $this->testHelper->getPositiveValueAsString(),
                "quantity" => null,
            ],
        ];
    }

    /**
     * @dataProvider getByIdsAndQuantityThrowsExceptionMessageEntityIdGreaterThanZero
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityThrowsExceptionMessageEntityIdGreaterThanZero($entityIds, $quantity)
    {
        $this->expectExceptionMessage(AssetHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AssetHelper($this->testHelper->getApi());
        $result = $helper->getByIdsAndQuantity($entityIds, $quantity);
    }

    /**
     * @return array
     */
    public function getByIdsAndQuantityThrowsExceptionMessageEntityIdGreaterThanZero(): array
    {
        return [
            [
                "entitiesIds" => $this->testHelper->getZeroOrNegativeValueAsString(),
                "quantity" => $this->testHelper->getPositiveValue(),
            ],
            [
                "entitiesIds" => $this->testHelper->getPositiveValueAndZeroOrNegativeValueAsString(),
                "quantity" => $this->testHelper->getPositiveValue(),
            ],
            [
                "entitiesIds" => $this->testHelper->getPositiveValueAndNullValueAsString(),
                "quantity" => $this->testHelper->getPositiveValue(),
            ],
        ];
    }

    /**
     * @dataProvider getByIdsAndQuantityThrowsExceptionMessageQuantityEqualGreaterThanZero
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityThrowsExceptionMessageQuantityEqualGreaterThanZero($entityIds, $quantity)
    {
        $this->expectExceptionMessage(AssetHelper::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new AssetHelper($this->testHelper->getApi());
        $result = $helper->getByIdsAndQuantity($entityIds, $quantity);
    }

    /**
     * @return array
     */
    public function getByIdsAndQuantityThrowsExceptionMessageQuantityEqualGreaterThanZero(): array
    {
        return [
            [
                "entitiesIds" => $this->testHelper->getNegativeValueAsString(),
                "quantity" => $this->testHelper->getNegativeValue(),
            ],
            [
                "entitiesIds" => $this->testHelper->getPositiveValueAsString(),
                "quantity" => $this->testHelper->getNegativeValue(),
            ],
            [
                "entitiesIds" => $this->testHelper->getPositiveValueAndNullValueAsString(),
                "quantity" => $this->testHelper->getNegativeValue(),
            ],
            [
                "entitiesIds" => $this->testHelper->getPositiveValueAndZeroOrNegativeValueAsString(),
                "quantity" => $this->testHelper->getNegativeValue(),
            ],
        ];
    }

    /**
     * @dataProvider getByIdsAndQuantityReturnsEmpty
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityReturnsEmpty(string $ids, int $quantity)
    {
        $helper = new AssetHelper($this->testHelper->getApi());
        $result = $helper->getByIdsAndQuantity($ids, $quantity);

        $this->assertEquals([], $result);
    }

    /**
     *
     * @return array[]
     */
    public function getByIdsAndQuantityReturnsEmpty(): array
    {
        return [
            [
                "ids" => "",
                "quantity" => $this->testHelper->getZeroOrNegativeValue()
            ],
            [
                "ids" => "0",
                "quantity" => $this->testHelper->getZeroOrNegativeValue()
            ],
            [
                "ids" => $this->testHelper->getNegativeValueAsString(),
                "quantity" => 0
            ],
            [
                "ids" => $this->testHelper->getPositiveValueAndNullValueAsString(),
                "quantity" => 0
            ],
            [
                "ids" => $this->testHelper->getPositiveValueAndZeroOrNegativeValueAsString(),
                "quantity" => 0
            ]
        ];
    }
}