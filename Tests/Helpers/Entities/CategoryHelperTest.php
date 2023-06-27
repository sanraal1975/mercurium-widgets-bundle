<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Services\CategoryApiService;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\CategoryHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class CategoryHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class CategoryHelperTest extends TestCase
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
    public function testConstructThrowsArgumentCounterErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new CategoryHelper();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     * @return void
     */
    public function testConstructThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new CategoryHelper($parameter);
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
        $helper = new CategoryHelper($this->testHelper->getApi());
        $service = $helper->getService();

        $this->assertInstanceOf(CategoryApiService::class, $service);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new CategoryHelper($this->testHelper->getApi());
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

        $helper = new CategoryHelper($this->testHelper->getApi());
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
        $this->expectExceptionMessage(CategoryHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new CategoryHelper($this->testHelper->getApi());
        $result = $helper->get($this->testHelper->getZeroOrNegativeValue());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByIdsThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new CategoryHelper($this->testHelper->getApi());
        $result = $helper->getByIds();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByIdsThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new CategoryHelper($this->testHelper->getApi());
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
        $this->expectExceptionMessage(CategoryHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new CategoryHelper($this->testHelper->getApi());
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
        $helper = new CategoryHelper($this->testHelper->getApi());
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

        $helper = new CategoryHelper($this->testHelper->getApi());
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

        $helper = new CategoryHelper($this->testHelper->getApi());
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
        $helper = new CategoryHelper($this->testHelper->getApi());
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
        $this->expectExceptionMessage(CategoryHelper::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new CategoryHelper($this->testHelper->getApi());
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
        $this->expectExceptionMessage(CategoryHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new CategoryHelper($this->testHelper->getApi());
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

        $helper = new CategoryHelper($this->testHelper->getApi());
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

        $helper = new CategoryHelper($this->testHelper->getApi());
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

    /**
     * @return void
     * @throws Exception
     */
    public function testGetChildrenThrowArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new CategoryHelper($this->testHelper->getApi());
        $result = $helper->getChildren();
    }

    /**
     * @dataProvider getChildrenThrowsTypeErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testGetChildrenThrowsTypeErrorException($parameters)
    {
        $this->expectException(TypeError::class);

        $helper = new CategoryHelper($this->testHelper->getApi());
        $result = $helper->getBy($parameters);
    }

    /**
     * @return array
     */
    public function getChildrenThrowsTypeErrorException(): array
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

    /**
     * @dataProvider getChildrenReturnEntity
     *
     * @param $category
     *
     * @return void
     * @throws Exception
     */
    public function testGetChildrenReturnEntity($category)
    {
        $helper = new CategoryHelper($this->testHelper->getApi());
        $result = $helper->getChildren($category);

        $this->assertEquals($category, $result);
    }

    /**
     * @return array
     */
    public function getChildrenReturnEntity(): array
    {
        return [
            [
                "category" => []
            ],
            [
                "category" => ["children" => []]
            ],
            [
                "category" => ["id" => $this->testHelper->getPositiveValue()]
            ],
        ];
    }

    /**
     * @dataProvider getChildrenRemovesInvalidChildren
     *
     * @param $category
     * @param $expected
     *
     * @return void
     * @throws Exception
     */
    public function testGetChildrenRemovesInvalidChildren($category, $expected)
    {
        $helper = new CategoryHelper($this->testHelper->getApi());
        $result = $helper->getChildren($category);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getChildrenRemovesInvalidChildren(): array
    {
        return [
            [
                "category" => ["children" => [0 => ""]],
                "expected" => ["children" => []]
            ],
            [
                "category" => ["children" => [0 => ["id" => ""]]],
                "expected" => ["children" => []]
            ],
            [
                "category" => ["children" => [0 => ["title" => "category"]]],
                "expected" => ["children" => []]
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetChildrenIdsThrowArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new CategoryHelper($this->testHelper->getApi());
        $result = $helper->getChildrenIds();
    }

    /**
     * @dataProvider getChildrenIdsThrowsTypeErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testGetChildrenIdsThrowsTypeErrorException($parameters)
    {
        $this->expectException(TypeError::class);

        $helper = new CategoryHelper($this->testHelper->getApi());
        $result = $helper->getBy($parameters);
    }

    /**
     * @return array
     */
    public function getChildrenIdsThrowsTypeErrorException(): array
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

    /**
     * @dataProvider getChildrenIdsReturnEmpty
     *
     * @param $category
     *
     * @return void
     * @throws Exception
     */
    public function testGetChildrenIdsReturnEmpty($category)
    {
        $helper = new CategoryHelper($this->testHelper->getApi());
        $result = $helper->getChildrenIds($category);

        $this->assertEquals([], $result);
    }

    /**
     * @return array
     */
    public function getChildrenIdsReturnEmpty(): array
    {
        return [
            [
                "category" => []
            ],
            [
                "category" => ["children" => []]
            ]
        ];
    }

    /**
     * @dataProvider getChildrenIdsReturnValue
     *
     * @param $category
     * @param $expected
     *
     * @return void
     */
    public function testGetChildrenIdsReturnValue($category, $expected)
    {
        $helper = new CategoryHelper($this->testHelper->getApi());
        $result = $helper->getChildrenIds($category);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function getChildrenIdsReturnValue(): array
    {
        return [
            [
                "category" => ["id" => 1],
                "expected" => [1]
            ],
            [
                "category" => ["id" => 1, "children" => []],
                "expected" => [1]
            ],
            [
                "category" => ["id" => 1, "children" => [["id" => 2]]],
                "expected" => [1,2]
            ]
        ];
    }

}