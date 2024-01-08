<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;
use Comitium5\ApiClientBundle\Client\Services\PagesApiService;
use Comitium5\ApiClientBundle\ValueObject\IdentifiedValue;
use Comitium5\MercuriumWidgetsBundle\Abstracts\Helpers\AbstractEntityHelper;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Exception;

/**
 * Class PageHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class PageHelper extends AbstractEntityHelper
{
    const ENTITY_ID_MUST_BE_GREATER_THAN_ZERO = "PageHelper::get. entityId must be greater than 0";

    /**
     * @var PagesApiService
     */
    private $service;

    /**
     * @param Client $api
     */
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

    /**
     * @param int $entityId
     *
     * @return array
     * @throws Exception
     */
    public function get(int $entityId): array
    {
        if ($entityId < 1) {
            throw new Exception(self::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);
        }

        return $this->service->find(new IdentifiedValue($entityId));
    }

    /**
     * @param string $entitiesIds
     *
     * @return array
     */
    public function getByIds(string $entitiesIds): array
    {
        // TODO: Implement getByIds() method.

        return [];
    }

    /**
     * @param string $entitiesIds
     * @param int $quantityOfEntities
     *
     * @return array
     */
    public function getByIdsAndQuantity(string $entitiesIds, int $quantityOfEntities = PHP_INT_MAX): array
    {
        // TODO: Implement getByIdsAndQuantity() method.

        return [];
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function getBy(array $parameters): array
    {
        // TODO: Implement getBy() method.

        return [];
    }

    /**
     * @return array
     */
    public function getLastPublished(): array
    {
        // TODO: Implement getLastPublished() method.

        return [];
    }
}