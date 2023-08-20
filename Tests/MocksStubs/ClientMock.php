<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;

class ClientMock extends Client
{
    /**
     * @param $resourceType
     * @param $id
     *
     * @return array
     */
    public function find($resourceType, $id): array
    {
        switch ($id) {
            case TestHelper::ENTITY_ID_TO_RETURN_EMPTY:
                return [
                    "statusCode" => 400,
                    "data" => [],
                ];
            case TestHelper::ENTITY_ID_TO_RETURN_EMPTY_SEARCHABLE:
                return [
                    "statusCode" => 200,
                    "data" => [
                        "results" => [
                            [
                                BundleConstants::ID_FIELD_KEY => $id,
                            ]
                        ]
                    ],
                ];
            case TestHelper::ENTITY_ID_TO_RETURN_ENTITY_WITH_CHILDREN:
                return [
                    "statusCode" => 200,
                    "data" => [
                        "results" => [
                            [
                                BundleConstants::ID_FIELD_KEY => $id,
                                BundleConstants::SEARCHABLE_FIELD_KEY => true,
                                "children" => [
                                    [
                                        BundleConstants::ID_FIELD_KEY => 1,
                                        BundleConstants::SEARCHABLE_FIELD_KEY => true,
                                    ]
                                ],
                            ]
                        ]
                    ]
                ];
        }

        return [
            "statusCode" => 200,
            "data" => [
                "results" => [
                    [
                        BundleConstants::ID_FIELD_KEY => $id,
                        BundleConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
        ];
    }

    /**
     * @param $resourceType
     * @param $parameters
     *
     * @return array[]
     */
    public function findBy($resourceType, $parameters): array
    {
        return [
            "statusCode" => 200,
            "data" => [
                "total" => 1,
                "limit" => 1,
                "pages" => 1,
                "page" => 1,
                "results" => [
                    [
                        BundleConstants::ID_FIELD_KEY => 1,
                        BundleConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
        ];
    }
}