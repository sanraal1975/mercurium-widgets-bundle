<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;

/**
 * Class AbstractEntityHelper
 *
 */
abstract class AbstractEntityHelper
{

    abstract public function getService():AbstractApiService;
}