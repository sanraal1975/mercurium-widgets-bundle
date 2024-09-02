<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;
use Comitium5\ApiClientBundle\Client\Services\MenuApiService;
use Comitium5\ApiClientBundle\ValueObject\IdentifiedValue;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Interfaces\EntityGetInterface;
use Comitium5\MercuriumWidgetsBundle\Interfaces\EntityGetServiceInterface;

/**
 * Class MenuHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class MenuHelper implements EntityGetInterface, EntityGetServiceInterface
{
    /**
     * @var MenuApiService
     */
    private $service;

    /**
     * @param Client $api
     */
    public function __construct(Client $api)
    {
        $factory = new ApiServiceFactory($api);
        $this->service = $factory->createMenuApiService();
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
     * @throws \Exception
     */
    public function get(int $entityId): array
    {
        return $this->service->find(new IdentifiedValue($entityId));
    }
}