<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Factories;

use Comitium5\ApiClientBundle\Client\Services\ActivitiesApiService;
use Comitium5\ApiClientBundle\Client\Services\ArticleApiService;
use Comitium5\ApiClientBundle\Client\Services\AssetApiService;
use Comitium5\ApiClientBundle\Client\Services\AuthorApiService;
use Comitium5\ApiClientBundle\Client\Services\CategoryApiService;
use Comitium5\ApiClientBundle\Client\Services\ContactApiService;
use Comitium5\ApiClientBundle\Client\Services\ContactSubscriptionApiService;
use Comitium5\ApiClientBundle\Client\Services\GalleryApiService;
use Comitium5\ApiClientBundle\Client\Services\MailingApiService;
use Comitium5\ApiClientBundle\Client\Services\MenuApiService;
use Comitium5\ApiClientBundle\Client\Services\PagesApiService;
use Comitium5\ApiClientBundle\Client\Services\PollApiService;
use Comitium5\ApiClientBundle\Client\Services\SubscriptionApiService;
use Comitium5\ApiClientBundle\Client\Services\TagApiService;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use PHPUnit\Framework\TestCase;

/**
 * Class ApiServiceFactoryTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Factory
 */
class ApiServiceFactoryTest extends TestCase
{
    /**
     * @var ClientMock
     */
    private $api;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);
        $testHelper = new TestHelper();
        $this->api = $testHelper->getApi();
    }

    /**
     * @return void
     */
    public function testCreateActivityApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createActivityApiService();

        $this->assertInstanceOf(ActivitiesApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateArticleApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createArticleApiService();

        $this->assertInstanceOf(ArticleApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateAssetApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createAssetApiService();

        $this->assertInstanceOf(AssetApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateAuthorApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createAuthorApiService();

        $this->assertInstanceOf(AuthorApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateCategoryApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createCategoryApiService();

        $this->assertInstanceOf(CategoryApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateContactApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createContactApiService();

        $this->assertInstanceOf(ContactApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateContactSubscriptionApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createContactSubscriptionApiService();

        $this->assertInstanceOf(ContactSubscriptionApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateGalleryApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createGalleryApiService();

        $this->assertInstanceOf(GalleryApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateMailingApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createMailingApiService();

        $this->assertInstanceOf(MailingApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateMenuApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createMenuApiService();

        $this->assertInstanceOf(MenuApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreatePageApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createPageApiService();

        $this->assertInstanceOf(PagesApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreatePollApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createPollApiService();

        $this->assertInstanceOf(PollApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateSubscriptionApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createSubscriptionApiService();

        $this->assertInstanceOf(SubscriptionApiService::class, $service);
    }

    /**
     * @return void
     */
    public function testCreateTagApiService()
    {
        $factory = new ApiServiceFactory($this->api);

        $service = $factory->createTagApiService();

        $this->assertInstanceOf(TagApiService::class, $service);
    }
}