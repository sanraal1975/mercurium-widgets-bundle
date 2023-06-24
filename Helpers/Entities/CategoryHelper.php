<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;
use Comitium5\ApiClientBundle\Client\Services\CategoryApiService;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;

class CategoryHelper extends AbstractEntityHelper
{
    /**
     * @var CategoryApiService
     */
    private $service;

    public function __construct(Client $api)
    {
        $factory = new ApiServiceFactory($api);
        $this->service = $factory->createCategoryApiService();
    }

    /**
     * @return AbstractApiService
     */
    public function getService(): AbstractApiService
    {
        return $this->service;
    }

    public function get(int $entityId): array
    {
        // TODO: Implement get() method.
        return [];
    }

    public function getByIds(string $entitiesIds): array
    {
        // TODO: Implement getByIds() method.
        return [];
    }

    public function getByIdsAndQuantity(string $entitiesIds, int $quantityOfEntities = PHP_INT_MAX): array
    {
        // TODO: Implement getByIdsAndQuantity() method.
        return [];
    }

    public function getBy(array $parameters): array
    {
        // TODO: Implement getBy() method.
        return [];
    }

    public function getLastPublished(): array
    {
        // TODO: Implement getLastPublished() method.
        return [];
    }

    public function getLastPublishedWithType(int $typeId): array
    {
        // TODO: Implement getLastPublishedWithType() method.
        return [];
    }
}