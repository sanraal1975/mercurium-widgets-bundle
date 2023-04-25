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
    const ENTITY_ID_MUST_BE_GREATER_THAN_ZERO = "ArticleHelper::get. entityId must be greater than 0";

    const QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO = "ArticleHelper::getByIdsAndQuantity. quantity must be equal or greater than 0";

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
    public function testGetByIdsWithEmptyString()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->getByIds("");

        $this->assertEquals([], $result);
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
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsWithStringWithZeroValue()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->getByIds("0");

        $this->assertEquals([], $result);
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
    public function testGetByIdsAndQuantityWithEmptyStringAndNegativeQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->getByIdsAndQuantity("", -1);

        $this->assertEquals([], $result);
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
    public function testGetByIdsAndQuantityWithStringWithZeroValueAndNegativeQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->getByIdsAndQuantity("0", -1);

        $this->assertEquals([], $result);
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
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithEmptyStringAndZeroQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->getByIdsAndQuantity("", 0);

        $this->assertEquals([], $result);
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
    public function testGetByIdsAndQuantityWithStringWithNegativeValueAndZeroQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->getByIdsAndQuantity("-1", 0);

        $this->assertEquals([], $result);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithStringWithZeroValueAndZeroQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->getByIdsAndQuantity("0", 0);

        $this->assertEquals([], $result);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithStringWithCorrectValueAndNullValueAndZeroQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->getByIdsAndQuantity("1," . null, 0);

        $this->assertEquals([], $result);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithStringWithCorrectValueAndNegativeValueAndZeroQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->getByIdsAndQuantity("1,-1", 0);

        $this->assertEquals([], $result);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByIdsAndQuantityWithStringWithCorrectValueAndZeroValueAndZeroQuantity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ArticleHelper($api);
        $result = $helper->getByIdsAndQuantity("1,0", 0);

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
}