<?php

namespace Comitium5\MercuriumWidgetsBundle\Factories;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\ArticleApiService;

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
     *
     * @return ArticleApiService
     */
    public function createArticleApiService(): ArticleApiService
    {
        return new ArticleApiService($this->api);
    }
}