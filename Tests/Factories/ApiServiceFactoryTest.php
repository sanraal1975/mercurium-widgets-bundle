<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Factories;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\ArticleApiService;
use Comitium5\ApiClientBundle\Client\Services\AssetApiService;
use Comitium5\ApiClientBundle\Client\Services\AuthorApiService;
use Comitium5\ApiClientBundle\Client\Services\CategoryApiService;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class ApiServiceFactoryTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Factory
 */
class ApiServiceFactoryTest extends TestCase
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
    public function testCreateArticleApiService()
    {
        $factory = new ApiServiceFactory($this->testHelper->getApi());

        $service = $factory->createArticleApiService();

        $this->assertInstanceOf(ArticleApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateAssetApiService()
    {
        $factory = new ApiServiceFactory($this->testHelper->getApi());

        $service = $factory->createAssetApiService();

        $this->assertInstanceOf(AssetApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateAuthorApiService()
    {
        $factory = new ApiServiceFactory($this->testHelper->getApi());

        $service = $factory->createAuthorApiService();

        $this->assertInstanceOf(AuthorApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateCategoryApiService()
    {
        $factory = new ApiServiceFactory($this->testHelper->getApi());

        $service = $factory->createCategoryApiService();

        $this->assertInstanceOf(CategoryApiService::class, $service);
    }
}