<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Helpers;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\VideoHelper;

/**
 * Class VideoHelperMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs
 */
class VideoHelperMock extends VideoHelper
{
    /**
     * @return array[]
     */
    public function getBy(array $parameters): array
    {
        return [
            "results" => [
                [
                    "id" => 1,
                    "searchable" => true
                ]
            ]
        ];
    }

}