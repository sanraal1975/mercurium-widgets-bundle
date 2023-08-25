<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;
use Comitium5\ApiClientBundle\Client\Services\TagApiService;
use Comitium5\ApiClientBundle\ValueObject\IdentifiedValue;
use Comitium5\ApiClientBundle\ValueObject\ParametersValue;
use Comitium5\MercuriumWidgetsBundle\Abstracts\Helpers\AbstractEntityHelper;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use Exception;

/**
 * Class TagHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class TagHelper extends AbstractEntityHelper
{
    const ENTITY_ID_MUST_BE_GREATER_THAN_ZERO = "TagHelper::get. entityId must be greater than 0";

    const QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO = "TagHelper::getByIdsAndQuantity. quantity must be equal or greater than 0";

    /**
     * @var TagApiService
     */
    private $service;

    /**
     * @param Client $api
     */
    public function __construct(Client $api)
    {
        $factory = new ApiServiceFactory($api);
        $this->service = $factory->createTagApiService();
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

        $result = $this->service->find(new IdentifiedValue($entityId));

        return ApiResultsHelper::extractOne($result);
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

        $helper = new EntityHelper();

        $entitiesIdsAsArray = explode(",", $entitiesIds);
        $entities = [];

        foreach ($entitiesIdsAsArray as $entityId) {
            $entityId = (int)$entityId;

            $entity = $this->get($entityId);

            if (!$helper->isValid($entity)) {
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

        $helper = new EntityHelper();

        $entitiesIdsAsArray = explode(",", $entitiesIds);
        $entities = [];

        foreach ($entitiesIdsAsArray as $entityId) {
            $entityId = (int)$entityId;
            $entity = $this->get($entityId);

            if (!$helper->isValid($entity)) {
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
                BundleConstants::LIMIT_FIELD_KEY => 1,
                BundleConstants::SORT_FIELD_KEY => BundleConstants::PUBLISHED_DESC,
            ]
        );

        return ApiResultsHelper::extractOne($results);
    }
}