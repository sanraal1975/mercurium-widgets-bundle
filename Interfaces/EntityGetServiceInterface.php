<?php

namespace Comitium5\MercuriumWidgetsBundle\Interfaces;

use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;

/**
 * Interface EntityBasicInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Interfaces
 */
interface EntityGetServiceInterface
{
    /**
     * @return AbstractApiService
     */
    public function getService(): AbstractApiService;
}