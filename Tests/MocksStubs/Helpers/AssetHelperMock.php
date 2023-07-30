<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Helpers;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AssetHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;

/**
 * Class AssetHelperMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs
 */
class AssetHelperMock extends AssetHelper
{
    /**
     * @param int $entityId
     *
     * @return int[]
     */
    public function get(int $entityId): array
    {
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
     * @return array[]
     */
    public function getBy(array $parameters): array
    {
        return [
            "results" => [
                [
                    "id" => 1
                ]
            ]
        ];
    }
}