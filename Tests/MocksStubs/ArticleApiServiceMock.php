<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs;

use Comitium5\ApiClientBundle\Client\Services\ArticleApiService;
use Comitium5\ApiClientBundle\ValueObject\ParametersValue;
use Exception;

/**
 * Class ArticleApiServiceMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs
 */
class ArticleApiServiceMock extends ArticleApiService
{
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