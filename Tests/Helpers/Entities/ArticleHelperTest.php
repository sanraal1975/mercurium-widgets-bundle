<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\ArticleApiService;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Exception;
use PHPUnit\Framework\TestCase;

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
}