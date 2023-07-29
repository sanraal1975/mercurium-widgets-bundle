<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ImageHelper;

/**
 * Class ImageHelperMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs
 */
class ImageHelperMock extends ImageHelper
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