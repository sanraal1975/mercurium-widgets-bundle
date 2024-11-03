<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AssetApiService;
use Comitium5\ApiClientBundle\ValueObject\IdentifiedValue;
use Comitium5\ApiClientBundle\ValueObject\ParametersValue;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Interfaces\EntityGetByInterface;
use Comitium5\MercuriumWidgetsBundle\Interfaces\EntityGetInterface;
use Exception;

/**
 * Class AssetHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class AssetHelper implements EntityGetInterface, EntityGetByInterface
{
    const ENTITY_ID_MUST_BE_GREATER_THAN_ZERO = "AssetHelper::get. entityId must be greater than 0";

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
}