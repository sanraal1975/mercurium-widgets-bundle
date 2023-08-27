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
            case TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET:
                return [
                    "statusCode" => 200,
                    "data" => [
                        "results" => [
                            [
                                BundleConstants::ID_FIELD_KEY => $id,
                                BundleConstants::SEARCHABLE_FIELD_KEY => true,
                                "asset" => [
                                    BundleConstants::ID_FIELD_KEY => 1
                                ]
                            ]
                        ]
                    ]
                ];
            case TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORKS:
                return [
                    "statusCode" => 200,
                    "data" => [
                        "results" => [
                            [
                                BundleConstants::ID_FIELD_KEY => $id,
                                BundleConstants::SEARCHABLE_FIELD_KEY => true,
                                "socialNetworks" => [
                                    [
                                        "socialNetwork" => "facebook",
                                        "url" => "https://www.foo.bar"
                                    ],
                                ]
                            ]
                        ]
                    ]
                ];
            case TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORK_WITH_EMPTY_URL:
                return [
                    "statusCode" => 200,
                    "data" => [
                        "results" => [
                            [
                                BundleConstants::ID_FIELD_KEY => $id,
                                BundleConstants::SEARCHABLE_FIELD_KEY => true,
                                "socialNetworks" => [
                                    [
                                        "socialNetwork" => "facebook",
                                        "url" => ""
                                    ],
                                ]
                            ]
                        ]
                    ]
                ];
            case TestHelper::AUTHOR_ID_TO_RETURN_WITH_BANNED_SOCIALNETWORK:
                return [
                    "statusCode" => 200,
                    "data" => [
                        "results" => [
                            [
                                BundleConstants::ID_FIELD_KEY => $id,
                                BundleConstants::SEARCHABLE_FIELD_KEY => true,
                                "socialNetworks" => [
                                    [
                                        "socialNetwork" => "banned_social_network",
                                        "url" => "https://www.foo.bar"
                                    ],
                                ]
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
                BundleConstants::LIMIT_FIELD_KEY => 1,
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