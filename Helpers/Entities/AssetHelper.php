<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;
use Comitium5\ApiClientBundle\Client\Services\AssetApiService;
use Comitium5\ApiClientBundle\ValueObject\IdentifiedValue;
use Comitium5\ApiClientBundle\ValueObject\ParametersValue;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use Exception;

/**
 * Class AssetHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class AssetHelper extends AbstractEntityHelper
{
    const ENTITY_ID_MUST_BE_GREATER_THAN_ZERO = "AssetHelper::get. entityId must be greater than 0";

    const QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO = "AssetHelper::getByIdsAndQuantity. quantity must be equal or greater than 0";

    const TYPE_ID_MUST_BE_GREATER_THAN_ZERO = "AssetHelper::getLastPublishedWithType. typeId must be greater than 0";

    /**
     * @var AssetApiService
     */
    private $service;

    /**
     * @param Client $api
     */
    public function __construct(Client $api)
    {
        $factory = new ApiServiceFactory($api);
        $this->service = $factory->createAssetApiService();
    }

    /**
     *
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
     * @throws Exception
     */
    public function getByIds(string $entitiesIds): array
    {
        if (empty($entitiesIds)) {
            return [];
        }

        $entitiesIdsAsArray = explode(",", $entitiesIds);
        $entities = [];
        foreach ($entitiesIdsAsArray as $entityId) {
            $entityId = (int)$entityId;

            $entity = $this->get($entityId);

            if (empty($entity)) {
                continue;
            }

            if (empty($entity['searchable'])) {
                continue;
            }

            $entities[] = $entity;
        }

        return $entities;
    }

    /**
     * @param string $entitiesIds
     * @param int $quantityOfEntities
     *
     * @return array
     * @throws Exception
     */
    public function getByIdsAndQuantity(string $entitiesIds, int $quantityOfEntities = PHP_INT_MAX): array
    {
        if (empty($entitiesIds)) {
            return [];
        }

        if ($quantityOfEntities < 0) {
            throw new Exception(self::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);
        }

        if ($quantityOfEntities == 0) {
            return [];
        }

        $entitiesIdsAsArray = explode(",", $entitiesIds);
        $entities = [];
        foreach ($entitiesIdsAsArray as $entityId) {
            $entityId = (int)$entityId;
            $entity = $this->get($entityId);

            if (empty($entity)) {
                continue;
            }

            if (empty($entity['searchable'])) {
                continue;
            }

            $entities[] = $entity;

            if (count($entities) == $quantityOfEntities) {
                break;
            }
        }

        return $entities;    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws Exception
     */
    public function getBy(array $parameters): array
    {
        return $this->service->findBy(
            new ParametersValue($parameters)
        );
    }

    /**
     *
     * @return array
     * @throws Exception
     */
    public function getLastPublished(): array
    {
        $results = $this->getBy(
            [
                "limit" => 1,
                "sort" => "publishedAt desc",
            ]
        );

        return ApiResultsHelper::extractResults($results);
    }
}