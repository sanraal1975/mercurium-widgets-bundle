<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;
use Comitium5\ApiClientBundle\Client\Services\CategoryApiService;
use Comitium5\ApiClientBundle\ValueObject\IdentifiedValue;
use Comitium5\ApiClientBundle\ValueObject\ParametersValue;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use Exception;

class CategoryHelper extends AbstractEntityHelper
{
    const ENTITY_ID_MUST_BE_GREATER_THAN_ZERO = "CategoryHelper::get. entityId must be greater than 0";

    const QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO = "CategoryHelper::getByIdsAndQuantity. quantity must be equal or greater than 0";

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

        return $entities;
    }

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

    /**
     * @param array $category
     *
     * @return array
     * @throws Exception
     */
    public function getChildren(array $category): array
    {
        if (empty($category)) {
            return $category;
        }

        if (empty($category['children'])) {
            return $category;
        }

        foreach ($category['children'] as $key => $child) {
            if (empty($child)) {
                unset ($category['children'][$key]);
                continue;
            }

            if (empty($child['id'])) {
                unset ($category['children'][$key]);
                continue;
            }

            $child = $this->get($child['id']);

            if (empty($child)) {
                unset($category['children'][$key]);
                continue;
            }

            if (empty($child['searchable'])) {
                unset($category['children'][$key]);
                continue;
            }

            if (!empty($child['children'])) {
                $category['children'][$key]['children'] = $this->getChildren($child);
            }
        }

        return $category;
    }

    /**
     * @param array $category
     *
     * @return array
     */
    public function getChildrenIds(array $category): array
    {
        if (empty($category)) {
            return [];
        }

        if (empty($category['id'])) {
            return [];
        }

        if (empty($category['children'])) {
            return [$category['id']];
        }

        $categoriesIds[] = $category['id'];
        foreach ($category['children'] as $child) {
            $categoriesIds = array_merge($categoriesIds, $this->getChildrenIds($child));
        }

        return $categoriesIds;
    }
}