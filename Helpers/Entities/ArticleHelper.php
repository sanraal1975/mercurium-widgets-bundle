<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;
use Comitium5\ApiClientBundle\Client\Services\ArticleApiService;
use Comitium5\ApiClientBundle\ValueObject\IdentifiedValue;
use Comitium5\MercuriumWidgetsBundle\Factory\ApiServiceFactory;
use Exception;

/**
 * Class ArticleHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class ArticleHelper extends AbstractEntityHelper
{
    /**
     * @var ArticleApiService
     */
    private $service;

    /**
     * @param Client $api
     */
    public function __construct(Client $api)
    {
        $factory = new ApiServiceFactory($api);
        $this->service = $factory->createArticleApiService();
    }

    /**
     * @return AbstractApiService
     */
    public function getService(): AbstractApiService
    {
        return $this->service;
    }

    /**
     * @param int $entityId
     *
     * @return array|mixed
     * @throws Exception
     */
    public function get(int $entityId)
    {
        if ($entityId < 1) {
            throw new Exception(__METHOD__ . ". entityId must be greater than 0");
        }

        return $this->service->find(new IdentifiedValue($entityId));
    }
}