<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs;

use Comitium5\ApiClientBundle\ApiClient\ResourcesTypes;
use Comitium5\ApiClientBundle\Client\Client;
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
//        if ($resourceType == ResourcesTypes::AUTHOR) {
//            echo PHP_EOL;
//            var_dump(__METHOD__);
//            echo PHP_EOL;
//            var_dump($id);
//            echo PHP_EOL;
//        }

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
                                "id" => $id,
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
                                "id" => $id,
                                "searchable" => true,
                                "children" => [
                                    [
                                        "id" => 1,
                                        "searchable" => true,
                                    ]
                                ],
                            ]
                        ]
                    ]
                ];
        }

//        if ($resourceType == ResourcesTypes::AUTHOR) {
//            echo PHP_EOL;
//            var_dump("final return");
//            echo PHP_EOL;
//        }

        return [
            "statusCode" => 200,
            "data" => [
                "results" => [
                    [
                        "id" => $id,
                        "searchable" => true
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
                        "id" => 1,
                        "searchable" => true
                    ]
                ]
            ],
        ];
    }
}