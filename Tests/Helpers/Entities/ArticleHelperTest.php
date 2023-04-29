<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

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
     *
     * @return void
     */
    public function testGetService()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);

        $service = $helper->getService();

        $this->assertInstanceOf(ArticleApiService::class, $service);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetWithNegativeId()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->get(-1);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetWithZeroId()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->get(0);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetWithNull()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new ArticleHelper($api);
        $helper->get(null);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetWithNoValue()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new ArticleHelper($api);
        $helper->get();
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsWithNullString()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new ArticleHelper($api);
        $helper->getByIds(null);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsWithStringWithNegativeValue()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getByIds("-1");
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
     *
     * @return array[]
     */
    public function getByIdsReturnEmpty()
    {
        /*
         *  0 -> empty string
         *  1 -> string with invalid value
         */

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
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsWithStringWithCorrectValueAndNullValue()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getByIds("1," . null);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsWithStringWithCorrectValueAndNegativeValue()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getByIds("1,-1");
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsWithStringWithCorrectValueAndZeroValue()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getByIds("1,0");
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithNullStringAndDefaultQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new ArticleHelper($api);
        $helper->getByIdsAndQuantity(null);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithNullStringAndNegativeQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new ArticleHelper($api);
        $helper->getByIdsAndQuantity(null, -1);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithNullStringAndZeroQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new ArticleHelper($api);
        $helper->getByIdsAndQuantity(null, 0);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithStringWithNegativeValueAndDefaultQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getByIdsAndQuantity("-1");
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithStringWithCorrectValueAndNullValueAndDefaultQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getByIdsAndQuantity("1," . null);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithStringWithCorrectValueAndNegativeValueAndDefaultQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getByIdsAndQuantity("1,-1");
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithStringWithCorrectValueAndZeroValueAndDefaultQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getByIdsAndQuantity("1,0");
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithStringWithNegativeValueAndNegativeQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getByIdsAndQuantity("-1", -1);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithStringWithCorrectValueAndNullValueAndNegativeQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getByIdsAndQuantity("1," . null, -1);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithStringWithCorrectValueAndNegativeValueAndNegativeQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getByIdsAndQuantity("1,-1", -1);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithStringWithCorrectValueAndZeroValueAndNegativeQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getByIdsAndQuantity("1,0", -1);
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
    public function getByIdsAndQuantityReturnEmpty()
    {

        /*
         * 0 -> string with wrong values and default quantity
         * 1 -> string with wrong values and wrong quantity
         * 2 -> string with wrong values and wrong quantity
         * 3 -> string with wrong values and quantity 0
         * 4 -> string with wrong values and quantity 0
         * 5 -> string with wrong values and quantity 0
         * 6 -> string with wrong values and quantity 0
         * 7 -> String with correct values and quantity 0
         */

        return [
            [
                "ids" => "",
                "quantity" => -1
            ],
            [
                "ids" => "0",
                "quantity" => -1
            ],
            [
                "ids" => "",
                "quantity" => 0
            ],
            [
                "ids" => "0",
                "quantity" => 0
            ],
            [
                "ids" => "-1",
                "quantity" => 0
            ],
            [
                "ids" => "1," . null,
                "quantity" => 0
            ],
            [
                "ids" => "1,-1",
                "quantity" => 0
            ],
            [
                "ids" => "1,0",
                "quantity" => 0
            ]
        ];
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithEmptyStringAndDefaultQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->getByIdsAndQuantity("");

        $this->assertEquals([], $result);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithStringWithZeroValueAndDefaultQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->getByIdsAndQuantity("0");

        $this->assertEquals([], $result);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetLastPublishedWithTypeWithNegativeType()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::TYPE_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getLastPublishedWithType(-1);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetLastPublishedWithTypeWithZeroType()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ArticleHelper::TYPE_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new ArticleHelper($api);
        $helper->getLastPublishedWithType(0);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetLastPublishedWithTypeWithNullType()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new ArticleHelper($api);
        $helper->getLastPublishedWithType(null);
    }

    /**
     * @dataProvider hasCategoryReturnFalse
     *
     * @param array $article
     * @param int $categoryId
     *
     * @return void
     */
    public function testHasCategoryReturnFalse(array $article, int $categoryId)
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->hasCategory($article, $categoryId);

        $this->assertFalse($result);
    }

    /**
     *
     * @return array[]
     */
    public function hasCategoryReturnFalse(): array
    {
        /*
         * 0 -> empty article
         * 1 -> article without categories key
         * 2 -> invalid categoryId
         */

        return [
            [
                "article" => [],
                "categoryId" => 0
            ],
            [
                "article" => ["id" => []],
                "categoryId" => 0
            ],
            [
                "article" => ['categories' => [0 => ["id" => 2]]],
                "categoryId" => 0
            ]
        ];
    }

    /**
     * @dataProvider hasCategoryReturnTrue
     *
     * @param array $article
     * @param int $categoryId
     *
     * @return void
     */
    public function testHasCategoryReturnTrue(array $article, int $categoryId)
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->hasCategory($article, $categoryId);

        $this->assertTrue($result);
    }

    /**
     *
     * @return array[]
     */
    public function hasCategoryReturnTrue(): array
    {
        return [
            [
                "article" => ['categories' => [0 => ["id" => 2]]],
                "categoryId" => 2
            ]
        ];
    }

    /**
     *
     * @return void
     */
    public function testHasCategoryTypeErrorExceptionInvalidArticle()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new ArticleHelper($api);
        $helper->hasCategory(null, 2);
    }

    /**
     *
     * @return void
     */
    public function testHasCategoryTypeErrorExceptionInvalidCategoryId()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new ArticleHelper($api);
        $helper->hasCategory([], null);
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
     * @return \array[][]
     */
    public function hasSubscriptionsReturnsFalse()
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