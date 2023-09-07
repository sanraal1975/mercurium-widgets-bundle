<?php

namespace Comitium5\MercuriumWidgetsBundle\Factories;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\ArticleApiService;
use Comitium5\ApiClientBundle\Client\Services\AssetApiService;
use Comitium5\ApiClientBundle\Client\Services\AuthorApiService;
use Comitium5\ApiClientBundle\Client\Services\CategoryApiService;
use Comitium5\ApiClientBundle\Client\Services\GalleryApiService;
use Comitium5\ApiClientBundle\Client\Services\PollApiService;
use Comitium5\ApiClientBundle\Client\Services\TagApiService;

/**
 * Class ApiServiceFactory
 *
 */
class ApiServiceFactory
{
    /**
     * @var Client
     */
    private $api;

    /**
     * @param Client $api
     */
    public function __construct(Client $api)
    {
        $this->api = $api;
    }

    /**
     * @return ArticleApiService
     */
    public function createArticleApiService(): ArticleApiService
    {
        return new ArticleApiService($this->api);
    }

    /**
     * @return AssetApiService
     */
    public function createAssetApiService(): AssetApiService
    {
        return new AssetApiService($this->api);
    }

    /**
     * @return AuthorApiService
     */
    public function createAuthorApiService(): AuthorApiService
    {
        return new AuthorApiService($this->api);
    }

    /**
     * @return CategoryApiService
     */
    public function createCategoryApiService(): CategoryApiService
    {
        return new CategoryApiService($this->api);
    }

    /**
     * @return TagApiService
     */
    public function createTagApiService(): TagApiService
    {
        return new TagApiService($this->api);
    }

    /**
     * @return GalleryApiService
     */
    public function createGalleryApiService(): GalleryApiService
    {
        return new GalleryApiService($this->api);
    }

    /**
     * @return PollApiService
     */
    public function createPollApiService(): PollApiService
    {
        return new PollApiService($this->api);
    }
}