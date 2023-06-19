<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\ArticleApiService;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
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
        $helper = new ArticleHelper($this->testHelper->getApi());

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

        $helper = new ArticleHelper($this->testHelper->getApi());
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

        $helper = new ArticleHelper($this->testHelper->getApi());
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

        $helper = new ArticleHelper($this->testHelper->getApi());
        $result = $helper->get($this->testHelper->getZeroOrNegativeValue());
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

        $helper = new ArticleHelper($this->testHelper->getApi());
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
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
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

        $helper = new ArticleHelper($this->testHelper->getApi());
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

        $helper = new ArticleHelper($this->testHelper->getApi());
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

        $helper = new ArticleHelper($this->testHelper->getApi());
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

        $helper = new ArticleHelper($this->testHelper->getApi());
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
     * @dataProvider getByIdsAndQuantityReturnEmpty
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityReturnEmpty(string $ids, int $quantity)
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
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
     * @return void
     * @throws Exception
     */
    public function testGetLastPublishedWithTypeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new ArticleHelper($this->testHelper->getApi());
        $helper->getLastPublishedWithType();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetLastPublishedWithTypeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new ArticleHelper($this->testHelper->getApi());
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

        $helper = new ArticleHelper($this->testHelper->getApi());
        $helper->getLastPublishedWithType($this->testHelper->getZeroOrNegativeValue());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testHasSubscriptionsThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new ArticleHelper($this->testHelper->getApi());
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

        $helper = new ArticleHelper($this->testHelper->getApi());
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
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->hasSubscriptions(["subscriptions" => ["id" => 1]]);

        $this->assertTrue($result);
    }

    /**
     * @dataProvider hasSubscriptionsReturnsFalse
     *
     * @return void
     */
    public function testHasSubscriptionsReturnsFalse(array $article)
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->hasSubscriptions($article);

        $this->assertFalse($result);
    }

    /**
     *
     * @return array[][]
     */
    public function hasSubscriptionsReturnsFalse(): array
    {
        /*
         * 0 -> empty article
         * 1 -> article without 'subscriptions' key
         * 2 -> article with empty 'subscriptions' key
         */

        return [
            [
                "article" => []
            ],
            [
                "article" => ["id" => 1]
            ],
            [
                "article" => ["subscriptions" => []]
            ]
        ];
    }
}