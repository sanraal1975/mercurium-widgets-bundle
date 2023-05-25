<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Factories;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\ArticleApiService;
use Comitium5\ApiClientBundle\Client\Services\AssetApiService;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class ApiServiceFactoryTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Factory
 */
class ApiServiceFactoryTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function testCreateArticleApiService()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $factory = new ApiServiceFactory($api);

        $service = $factory->createArticleApiService();

        $this->assertInstanceOf(ArticleApiService::class, $service);
    }

    /**
     *
     * @return void
     */
    public function testCreateAssetApiService()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $factory = new ApiServiceFactory($api);

        $service = $factory->createAssetApiService();

        $this->assertInstanceOf(AssetApiService::class, $service);
    }
}