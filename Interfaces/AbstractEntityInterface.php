<?php

namespace Comitium5\MercuriumWidgetsBundle\Interfaces;

use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;

/**
 * Interface AbstractEntityInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Interfaces
 */
interface AbstractEntityInterface
{
    /**
     *
     * @return AbstractApiService
     */
    public function getService(): AbstractApiService;

    /**
     * @param string $entitiesIds
     *
     * @return array
     */
    public function getByIds(string $entitiesIds): array;

    /**
     * @param string $entitiesIds
     * @param int $quantityOfEntities
     *
     * @return array
     */
    public function getByIdsAndQuantity(string $entitiesIds, int $quantityOfEntities = PHP_INT_MAX): array;

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function getBy(array $parameters): array;

    /**
     *
     * @return array
     */
    public function getLastPublished(): array;

    /**
     * @param int $typeId
     *
     * @return array
     */
    public function getLastPublishedWithType(int $typeId): array;
}