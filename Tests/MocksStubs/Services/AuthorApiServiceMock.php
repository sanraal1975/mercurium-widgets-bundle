<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Services;

use Comitium5\ApiClientBundle\Client\Services\AuthorApiService;
use Comitium5\ApiClientBundle\ValueObject\IdentifiedValue;
use Comitium5\ApiClientBundle\ValueObject\ParametersValue;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Exception;

/**
 * Class AuthorApiServiceMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs
 */
class AuthorApiServiceMock extends AuthorApiService
{
    /**
     * @param IdentifiedValue $identifiedValue
     *
     * @return array
     */
    public function find(IdentifiedValue $identifiedValue): array
    {
        $entityId = $identifiedValue->getId();

        switch ($entityId) {
            case TestHelper::ENTITY_ID_TO_RETURN_EMPTY:
                return [];
            case TestHelper::ENTITY_ID_TO_RETURN_EMPTY_SEARCHABLE:
                return [
                    "id" => $entityId,
                ];
        }

        return [
            "id" => $entityId,
            "searchable" => true
        ];
    }

    /**
     * @param ParametersValue $parametersValue
     *
     * @return array
     * @throws Exception
     */
    public function findBy(ParametersValue $parametersValue): array
    {
        return [
            "total" => 1,
            "limit" => 1,
            "pages" => 1,
            "page" => 1,
            "results" => [
                [
                    "id" => 1,
                    "searchable" => 1
                ]
            ]
        ];
    }

}