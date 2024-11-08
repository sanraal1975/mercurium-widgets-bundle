<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;
use Comitium5\ApiClientBundle\Client\Services\CategoryApiService;
use Comitium5\ApiClientBundle\ValueObject\IdentifiedValue;
use Comitium5\ApiClientBundle\ValueObject\ParametersValue;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use Comitium5\MercuriumWidgetsBundle\Interfaces\EntityGetByInterface;
use Comitium5\MercuriumWidgetsBundle\Interfaces\EntityGetInterface;
use Comitium5\MercuriumWidgetsBundle\Interfaces\EntityGetLastInterface;
use Comitium5\MercuriumWidgetsBundle\Interfaces\EntityGetServiceInterface;
use Exception;

/**
 * Class CategoryHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class CategoryHelper implements EntityGetServiceInterface, EntityGetInterface, EntityGetByInterface, EntityGetLastInterface
{
    const ENTITY_ID_MUST_BE_GREATER_THAN_ZERO = "CategoryHelper::get. entityId must be greater than 0";

    const QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO = "CategoryHelper::getByIdsAndQuantity. quantity must be equal or greater than 0";

    const GROUP_ID_MUST_BE_GREATER_THAN_ZERO = "CategoryHelper::getByGroup. group id must be greater than 0";

    const GET_BY_GROUP_QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO = "CategoryHelper::getByGroup. quantity must be equal or greater than 0";

    const QUANTITY_MUST_BE_EQUAL_OR_LESS_THAN_HUNDRED = "CategoryHelper::getByGroup. quantity must be equal or less than 100";

    /**
     * @var CategoryApiService
     */
    private CategoryApiService $service;

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
    public function getLast(): array
    {
        $results = $this->getBy(
            [
                EntityConstants::LIMIT_FIELD_KEY => 1,
                EntityConstants::SORT_FIELD_KEY => EntityConstants::PUBLISHED_DESC,
            ]
        );

        return ApiResultsHelper::extractOne($results);
    }

    /**
     * @param array $category
     *
     * @return array
     * @throws Exception
     */
    public function getChildren(array $category): array
    {
        if (!empty($category)) {
            if (!empty($category["children"])) {
                $helper = new EntityHelper();
                foreach ($category["children"] as $key => $child) {
                    if (empty($child)) {
                        unset ($category["children"][$key]);
                        continue;
                    }

                    if (empty($child[EntityConstants::ID_FIELD_KEY])) {
                        unset ($category["children"][$key]);
                        continue;
                    }

                    $child = $this->get($child[EntityConstants::ID_FIELD_KEY]);

                    if (!$helper->isValid($child)) {
                        unset($category["children"][$key]);
                        continue;
                    }

                    $category["children"][$key] = $child;

                    if (!empty($child["children"])) {
                        $child = $this->getChildren($child);
                        $category["children"][$key] = $child;
                    }
                }
            }
        }
        return $category;
    }

    /**
     * @param array $category
     *
     * @return array
     */
    public function getCategoryIdAndChildrenIds(array $category): array
    {
        if (empty($category)) {
            return [];
        }

        if (empty($category[EntityConstants::ID_FIELD_KEY])) {
            return [];
        }

        if (empty($category["children"])) {
            return [$category[EntityConstants::ID_FIELD_KEY]];
        }

        $categoriesIds[] = $category[EntityConstants::ID_FIELD_KEY];
        foreach ($category["children"] as $child) {
            $categoriesIds = array_merge($categoriesIds, $this->getCategoryIdAndChildrenIds($child));
        }

        return $categoriesIds;
    }

    /**
     * @param int $groupId
     * @param int $quantity
     *
     * @return array
     * @throws Exception
     */
    public function getByGroup(int $groupId, int $quantity = 100): array
    {
        $results = [];
        if (!empty($groupId)) {
            if ($groupId < 1) {
                throw new Exception(self::GROUP_ID_MUST_BE_GREATER_THAN_ZERO);
            }
            if (!empty($quantity)) {
                if ($quantity < 0) {
                    throw new Exception(self::GET_BY_GROUP_QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);
                }
                if ($quantity > 100) {
                    throw new Exception(self::QUANTITY_MUST_BE_EQUAL_OR_LESS_THAN_HUNDRED);
                }

                $parameters = [
                    EntityConstants::GROUPS_FIELD_KEY => $groupId,
                    EntityConstants::ORDER_FIELD_KEY => EntityConstants::TITLE_ASC,
                    EntityConstants::LIMIT_FIELD_KEY => $quantity
                ];

                $results = $this->getBy($parameters);
            }
        }
        return $results;
    }
}