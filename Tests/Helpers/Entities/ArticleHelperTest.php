<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Services\ArticleApiService;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class ArticleHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class ArticleHelperTest extends TestCase
{
    /**
     * @var ClientMock
     */
    private $api;

    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $testHelper = new TestHelper();
        $this->testHelper = $testHelper;
        $this->api = $testHelper->getApi();
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new ArticleHelper();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @return void
     */
    public function testConstructThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new ArticleHelper($parameter);
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
        $helper = new ArticleHelper($this->api);

        $service = $helper->getService();

        $this->assertInstanceOf(ArticleApiService::class, $service);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new ArticleHelper($this->api);
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

        $helper = new ArticleHelper($this->api);
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
        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($this->api);
        $result = $helper->get($this->testHelper->getZeroOrNegativeValue());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGet()
    {
        $helper = new ArticleHelper($this->api);
        $result = $helper->get(1);

        $expected = [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::SEARCHABLE_FIELD_KEY => true];

        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider getByIdsThrowsExceptionMessageEntityIdGreaterThanZero
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsThrowsExceptionMessageEntityIdGreaterThanZero($entitiesIds)
    {
        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($this->api);
        $helper->getByIds($entitiesIds);
    }

    /**
     *
     * @return array[]
     */
    public function getByIdsThrowsExceptionMessageEntityIdGreaterThanZero(): array
    {
        return [
            [
                "entitiesIds" => $this->testHelper->getZeroOrNegativeValueAsString()
            ],
            [
                "entitiesIds" => $this->testHelper->getPositiveValueAndNullValueAsString()
            ],
            [
                "entitiesIds" => $this->testHelper->getPositiveValueAndZeroOrNegativeValueAsString()
            ]
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
        $helper = new ArticleHelper($this->api);
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
     * @dataProvider getByIdsReturnEntities
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsReturnEntities($entitiesIds, $expected)
    {
        $helper = new ArticleHelper($this->api);
        $result = $helper->getByIds($entitiesIds);

        $this->assertEquals($expected, $result);
    }

    /**
     *
     * @return array[]
     */
    public function getByIdsReturnEntities(): array
    {
        return [
            [
                "entitiesIds" => "1",
                "expected" => [[
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::SEARCHABLE_FIELD_KEY => true
                ]]
            ],
            [
                "entitiesIds" => "1," . $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                "expected" => [[
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::SEARCHABLE_FIELD_KEY => true
                ]]
            ],
            [
                "entitiesIds" => "1," . $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY_SEARCHABLE,
                "expected" => [[
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::SEARCHABLE_FIELD_KEY => true
                ]]
            ]
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new ArticleHelper($this->api);
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

        $helper = new ArticleHelper($this->api);
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
        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($this->api);
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
        $this->expectExceptionMessage(ArticleHelper::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($this->api);
        $helper->getByIdsAndQuantity($entityIds, $quantity);
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
     * @dataProvider getByIdsAndQuantityReturnEmpty
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityReturnEmpty(string $ids, int $quantity)
    {
        $helper = new ArticleHelper($this->api);

        $result = $helper->getByIdsAndQuantity($ids, $quantity);

        $this->assertEquals([], $result);
    }

    /**
     *
     * @return array[]
     */
    public function getByIdsAndQuantityReturnEmpty(): array
    {
        return [
            [
                "ids" => "",
                "quantity" => $this->testHelper->getZeroOrNegativeValue(),
            ],
            [
                "ids" => "0",
                "quantity" => $this->testHelper->getZeroOrNegativeValue(),
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
            ],
            [
                "ids" => "1,0",
                "quantity" => 0
            ]
        ];
    }

    /**
     * @dataProvider getByIdsAndQuantityReturnEntities
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityReturnEntities($entitiesIds, $quantity, $expected)
    {
        $helper = new ArticleHelper($this->api);

        $result = $helper->getByIdsAndQuantity($entitiesIds, $quantity);

        $this->assertEquals($expected, $result);
    }

    /**
     *
     * @return array[]
     */
    public function getByIdsAndQuantityReturnEntities(): array
    {
        return [
            [
                "entitiesIds" => "1",
                "quantity" => PHP_INT_MAX,
                "expected" => [[
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::SEARCHABLE_FIELD_KEY => true
                ]]
            ],
            [
                "entitiesIds" => "1," . $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                "quantity" => PHP_INT_MAX,
                "expected" => [[
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::SEARCHABLE_FIELD_KEY => true
                ]]
            ],
            [
                "entitiesIds" => "1," . $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY_SEARCHABLE,
                "quantity" => PHP_INT_MAX,
                "expected" => [[
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::SEARCHABLE_FIELD_KEY => true
                ]]
            ],
            [
                "entitiesIds" => "1,2",
                "quantity" => PHP_INT_MAX,
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ],
                    [
                        EntityConstants::ID_FIELD_KEY => 2,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "entitiesIds" => "1,2,3",
                "quantity" => 2,
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ],
                    [
                        EntityConstants::ID_FIELD_KEY => 2,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "entitiesIds" => "1," . $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY . ",3",
                "quantity" => 2,
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ],
                    [
                        EntityConstants::ID_FIELD_KEY => 3,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "entitiesIds" => "1," . $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY_SEARCHABLE . ",3",
                "quantity" => 2,
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ],
                    [
                        EntityConstants::ID_FIELD_KEY => 3,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetBy()
    {
        $helper = new ArticleHelper($this->api);

        $result = $helper->getBy(
            [
                EntityConstants::LIMIT_FIELD_KEY => 1
            ]
        );


        $expected = [
            "total" => 1,
            EntityConstants::LIMIT_FIELD_KEY => 1,
            "pages" => 1,
            "page" => 1,
            "results" => [
                [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::SEARCHABLE_FIELD_KEY => 1
                ]
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetLastPublishedReturnsEntity()
    {
        $helper = new ArticleHelper($this->api);

        $result = $helper->getLastPublished();

        $expected = [
            EntityConstants::ID_FIELD_KEY => 1,
            EntityConstants::SEARCHABLE_FIELD_KEY => true
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetLastPublishedWithTypeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new ArticleHelper($this->api);
        $helper->getLastPublishedWithType();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetLastPublishedWithTypeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new ArticleHelper($this->api);
        $helper->getLastPublishedWithType(null);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetLastPublishedWithTypeThrowsExceptionMessageTypeGreaterThanZero()
    {
        $this->expectExceptionMessage(ArticleHelper::TYPE_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($this->api);
        $helper->getLastPublishedWithType($this->testHelper->getZeroOrNegativeValue());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetLastPublishedWithTypeReturnsEntity()
    {
        $helper = new ArticleHelper($this->api);

        $result = $helper->getLastPublishedWithType(1);

        $expected = [
            EntityConstants::ID_FIELD_KEY => 1,
            EntityConstants::SEARCHABLE_FIELD_KEY => true
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testHasSubscriptionsThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new ArticleHelper($this->api);
        $result = $helper->hasSubscriptions();
    }

    /**
     * @dataProvider hasSubscriptionsThrowsTypeErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testHasSubscriptionsThrowsTypeErrorException($article)
    {
        $this->expectException(TypeError::class);

        $helper = new ArticleHelper($this->api);
        $result = $helper->hasSubscriptions($article);
    }

    /**
     * @return array
     */
    public function hasSubscriptionsThrowsTypeErrorException(): array
    {
        return [
            [
                "article" => null
            ],
            [
                "article" => $this->testHelper->getPositiveValue()
            ],
            [
                "article" => $this->testHelper->getZeroOrNegativeValue()
            ]
        ];
    }

    /**
     *
     * @return void
     */
    public function testHasSubscriptionsReturnsTrue()
    {
        $helper = new ArticleHelper($this->api);
        $result = $helper->hasSubscriptions([EntityConstants::SUBSCRIPTIONS_FIELD_KEY => [EntityConstants::ID_FIELD_KEY => 1]]);

        $this->assertTrue($result);
    }

    /**
     * @dataProvider hasSubscriptionsReturnsFalse
     *
     * @return void
     */
    public function testHasSubscriptionsReturnsFalse(array $article)
    {
        $helper = new ArticleHelper($this->api);
        $result = $helper->hasSubscriptions($article);

        $this->assertFalse($result);
    }

    /**
     *
     * @return array[][]
     */
    public function hasSubscriptionsReturnsFalse(): array
    {
        return [
            [
                "article" => []
            ],
            [
                "article" => [EntityConstants::ID_FIELD_KEY => 1]
            ],
            [
                "article" => [EntityConstants::SUBSCRIPTIONS_FIELD_KEY => []]
            ]
        ];
    }
}