<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;
use Comitium5\ApiClientBundle\Client\Services\PollApiService;
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
 * Class PollHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class PollHelper implements EntityGetServiceInterface, EntityGetInterface, EntityGetByInterface, EntityGetLastInterface
{
    const ENTITY_ID_MUST_BE_GREATER_THAN_ZERO = "PollHelper::get. entityId must be greater than 0";

    const QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO = "PollHelper::getByIdsAndQuantity. quantity must be equal or greater than 0";

    /**
     * @var PollApiService
     */
    private PollApiService $service;

    /**
     * @param Client $api
     */
    public function __construct(Client $api)
    {
        $factory = new ApiServiceFactory($api);
        $this->service = $factory->createPollApiService();
    }

    /**
     *
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
                EntityConstants::SORT_FIELD_KEY => EntityConstants::PUBLISHED_DESC
            ]
        );

        return ApiResultsHelper::extractOne($results);
    }
}