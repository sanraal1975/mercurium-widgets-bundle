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

        $this->expectException(Exception::class);

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

        $this->expectException(Exception::class);

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

        $this->expectException(Exception::class);

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

        $this->expectException(Exception::class);

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

        $this->expectException(Exception::class);

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

        $this->expectException(Exception::class);

        $helper = new ArticleHelper($api);
        $helper->getByIds("1,0");
    }
}