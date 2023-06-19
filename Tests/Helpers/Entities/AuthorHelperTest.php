<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Services\AuthorApiService;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AuthorHelper;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class AuthorHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class AuthorHelperTest extends TestCase
{
    /**
     * @var CommonEntitiesHelperTestFunctions
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
        $this->testHelper = new CommonEntitiesHelperTestFunctions();
    }
    
    /**
     * @return void
     */
    public function testConstructThrowsArgumentCounterErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new AuthorHelper();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     * @return void
     */
    public function testConstructThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new AuthorHelper($parameter);
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
        $helper = new AuthorHelper($this->testHelper->getApi());
        $service = $helper->getService();

        $this->assertInstanceOf(AuthorApiService::class, $service);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new AuthorHelper($this->testHelper->getApi());
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

        $helper = new AuthorHelper($this->testHelper->getApi());
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
    public function testGetThrowsCustomExceptionEntityIdGreaterThanZero()
    {
        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($this->testHelper->getApi());
        $result = $helper->get($this->testHelper->getZeroOrNegativeValue());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByIdsThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new AuthorHelper($this->testHelper->getApi());
        $result = $helper->getByIds();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByIdsThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new AuthorHelper($this->testHelper->getApi());
        $result = $helper->getByIds(null);
    }

    /**
     * @dataProvider getByIdsThrowsExceptionMessageEntityIdGreaterThanZero
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsThrowsExceptionMessageEntityIdGreaterThanZero(string $parameter)
    {
        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($this->testHelper->getApi());
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
    public function testGetByIdsReturnEmpty()
    {
        $helper = new AuthorHelper($this->testHelper->getApi());
        $result = $helper->getByIds("");

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

        $helper = new AuthorHelper($this->testHelper->getApi());
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

        $helper = new AuthorHelper($this->testHelper->getApi());
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
                "quantity" => 1,
            ],
            [
                "entitiesIds" => "1",
                "quantity" => "",
            ],
            [
                "entitiesIds" => "1",
                "quantity" => null,
            ],
        ];
    }

    /**
     * @dataProvider getByIdsAndQuantityReturnEmpty
     *
     * @param $entitiesIds
     * @param $quantity
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityReturnEmpty($entitiesIds, $quantity)
    {
        $helper = new AuthorHelper($this->testHelper->getApi());
        $result = $helper->getByIdsAndQuantity($entitiesIds, $quantity);

        $this->assertEquals([], $result);
    }

    /**
     * @return array
     */
    public function getByIdsAndQuantityReturnEmpty(): array
    {
        return [
            [
                "entitiesIds" => "",
                "quantity" => 1,
            ],
            [
                "entitiesIds" => "1",
                "quantity" => 0,
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityThrowsExceptionMessageQuantityGreaterThanZero()
    {
        $this->expectExceptionMessage(AuthorHelper::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($this->testHelper->getApi());
        $result = $helper->getByIdsAndQuantity($this->testHelper->getPositiveValueAsString(), $this->testHelper->getZeroOrNegativeValue());
    }

    /**
     * @dataProvider getByIdsAndQuantityThrowsExceptionMessageEntityIdGreaterThanZero
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityThrowsExceptionMessageEntityIdGreaterThanZero($entityIds, $quantity)
    {
        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($this->testHelper->getApi());
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
     * @return void
     * @throws Exception
     */
    public function testGetByThrowArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new AuthorHelper($this->testHelper->getApi());
        $result = $helper->getBy();
    }

    /**
     * @dataProvider getByThrowsTypeErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testGetByThrowsTypeErrorException($parameters)
    {
        $this->expectException(TypeError::class);

        $helper = new AuthorHelper($this->testHelper->getApi());
        $result = $helper->getBy($parameters);
    }

    /**
     * @return array
     */
    public function getByThrowsTypeErrorException(): array
    {
        return [
            [
                "parameters" => 1
            ],
            [
                "parameters" => null
            ],
        ];
    }
}