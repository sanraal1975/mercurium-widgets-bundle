<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;

/**
 * Class AbstractEntityHelper
 *
 */
abstract class AbstractEntityHelper
{

    abstract public function getService(): AbstractApiService;

    abstract public function getByIds(string $entitiesIds): array;

    abstract public function getByIdsAndQuantity(string $entitiesIds, int $quantityOfEntities = PHP_INT_MAX): array;

}