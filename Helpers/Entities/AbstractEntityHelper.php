<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;
use Comitium5\MercuriumWidgetsBundle\Interfaces\AbstractEntityInterface;

/**
 * Class AbstractEntityHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
abstract class AbstractEntityHelper implements AbstractEntityInterface
{
    /**
     *
     * @return AbstractApiService
     */
    abstract public function getService(): AbstractApiService;

    /**
     * @param int $entityId
     *
     * @return array
     */
    abstract public function get(int $entityId): array;

    /**
     * @param string $entitiesIds
     *
     * @return array
     */
    abstract public function getByIds(string $entitiesIds): array;

    /**
     * @param string $entitiesIds
     * @param int $quantityOfEntities
     *
     * @return array
     */
    abstract public function getByIdsAndQuantity(string $entitiesIds, int $quantityOfEntities = PHP_INT_MAX): array;

    /**
     * @param array $parameters
     *
     * @return array
     */
    abstract public function getBy(array $parameters): array;

    /**
     *
     * @return array
     */
    abstract public function getLastPublished(): array;
}