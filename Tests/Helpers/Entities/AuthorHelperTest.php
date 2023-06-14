<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
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
     * @return void
     */
    public function testGetService()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new AuthorHelper($api);

        $service = $helper->getService();

        $this->assertInstanceOf(AuthorApiService::class, $service);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetWithNegativeId()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
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

        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
        $helper->get(0);
    }


    /**
     * @return void
     * @throws Exception
     */
    public function testGetWithNull()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new AuthorHelper($api);
        $helper->get(null);
    }


    /**
     * @return void
     * @throws Exception
     */
    public function testGetWithNoValue()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new AuthorHelper($api);
        $helper->get();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByIdsWithNullString()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new AuthorHelper($api);
        $helper->getByIds(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByIdsWithStringWithNegativeValue()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
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

        $helper = new AuthorHelper($api);
        $result = $helper->getByIds($ids);

        $this->assertEquals([], $result);
    }

    /**
     * @return array[]
     */
    public function getByIdsReturnEmpty(): array
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

        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
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

        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
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

        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
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

        $helper = new AuthorHelper($api);
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

        $helper = new AuthorHelper($api);
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

        $helper = new AuthorHelper($api);
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

        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
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

        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
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

        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
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

        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
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

        $this->expectExceptionMessage(AuthorHelper::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
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

        $this->expectExceptionMessage(AuthorHelper::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
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

        $this->expectExceptionMessage(AuthorHelper::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
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

        $this->expectExceptionMessage(AuthorHelper::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new AuthorHelper($api);
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

        $helper = new AuthorHelper($api);
        $result = $helper->getByIdsAndQuantity($ids, $quantity);

        $this->assertEquals([], $result);
    }

    /**
     *
     * @return array[]
     */
    public function getByIdsAndQuantityReturnEmpty(): array
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

        $helper = new AuthorHelper($api);
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

        $helper = new AuthorHelper($api);
        $result = $helper->getByIdsAndQuantity("0");

        $this->assertEquals([], $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetLastPublishedWithTypeWithWrongTypeParameter()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new AuthorHelper($api);
        $result = $helper->getLastPublishedWithType(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetLastPublishedWithTypeReturnEmptyValue()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new AuthorHelper($api);
        $result = $helper->getLastPublishedWithType(1);

        $this->assertEquals([], $result);
    }


}