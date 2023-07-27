<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AuthorHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;

/**
 * Class AuthorHelperMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs
 */
class AuthorHelperMock extends AuthorHelper
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