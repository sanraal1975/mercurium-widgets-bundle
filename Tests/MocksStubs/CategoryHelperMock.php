<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\CategoryHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;

/**
 * Class CategoryHelperMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs
 */
class CategoryHelperMock extends CategoryHelper
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
        }

        return [
            "id" => $entityId
        ];
    }
}