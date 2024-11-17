<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs;

use Comitium5\ApiClientBundle\ApiClient\ResourcesTypes;
use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Symfony\Component\HttpFoundation\Response;

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
                    "statusCode" => Response::HTTP_NOT_FOUND,
                    "data" => [],
                ];
            case TestHelper::ENTITY_ID_TO_RETURN_EMPTY_SEARCHABLE:
                return [
                    "statusCode" => Response::HTTP_OK,
                    "data" => [
                        EntityConstants::ID_FIELD_KEY => $id,
                    ],
                ];
            case TestHelper::ENTITY_ID_TO_RETURN_ENTITY_WITH_CHILDREN:
                return [
                    "statusCode" => Response::HTTP_OK,
                    "data" => [
                        EntityConstants::ID_FIELD_KEY => $id,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        "children" => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true,
                            ]
                        ],
                    ]
                ];
            case TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET:
                return [
                    "statusCode" => Response::HTTP_OK,
                    "data" => [
                        EntityConstants::ID_FIELD_KEY => $id,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        "asset" => [
                            EntityConstants::ID_FIELD_KEY => 1
                        ]
                    ]
                ];
            case TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORKS:
                return [
                    "statusCode" => Response::HTTP_OK,
                    "data" => [
                        EntityConstants::ID_FIELD_KEY => $id,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        "socialNetworks" => [
                            [
                                "socialNetwork" => "facebook",
                                "url" => "https://www.foo.bar"
                            ],
                        ]
                    ]
                ];
            case TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORK_WITH_EMPTY_URL:
                return [
                    "statusCode" => Response::HTTP_OK,
                    "data" => [
                        EntityConstants::ID_FIELD_KEY => $id,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        "socialNetworks" => [
                            [
                                "socialNetwork" => "facebook",
                                "url" => ""
                            ],
                        ]
                    ]
                ];
            case TestHelper::AUTHOR_ID_TO_RETURN_WITH_BANNED_SOCIALNETWORK:
                return [
                    "statusCode" => Response::HTTP_OK,
                    "data" => [
                        EntityConstants::ID_FIELD_KEY => $id,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        "socialNetworks" => [
                            [
                                "socialNetwork" => "banned_social_network",
                                "url" => "https://www.foo.bar"
                            ],
                        ]
                    ]
                ];
                case TestHelper::MENU_WITH_ITEMS:
                    return [
                        "statusCode" => Response::HTTP_OK,
                        "data" => [
                            EntityConstants::SEARCHABLE_FIELD_KEY => true,
                            "items" => [
                                [
                                    "title" => "foo",
                                    "permalink" => "/bar"
                                ]
                            ]
                        ]
                    ];
                case TestHelper::MENU_WITHOUT_ITEMS:
                    return [
                        "statusCode" => Response::HTTP_OK,
                        "data" => [
                            EntityConstants::SEARCHABLE_FIELD_KEY => true,
                            "items" => []
                        ]
                    ];
            }

        return [
            "statusCode" => Response::HTTP_OK,
            "data" => [
                EntityConstants::ID_FIELD_KEY => $id,
                EntityConstants::SEARCHABLE_FIELD_KEY => true
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
        switch ($resourceType) {
            case ResourcesTypes::CONTACT:
                if ($parameters['email'] == TestHelper::EMAIL_CONTACT_NOT_FOUND) {
                    return [
                        "statusCode" => Response::HTTP_NOT_FOUND,
                        "data" => [],
                    ];
                } else {
                    return [
                        "statusCode" => Response::HTTP_OK,
                        "data" => [
                            "total" => 1,
                            EntityConstants::LIMIT_FIELD_KEY => 1,
                            "pages" => 1,
                            "page" => 1,
                            "results" => [
                                [
                                    EntityConstants::ID_FIELD_KEY => 1,
                                    EntityConstants::SEARCHABLE_FIELD_KEY => true,
                                    EntityConstants::EMAIL_FIELD_KEY => $parameters['email'],
                                ]
                            ]
                        ],
                    ];
                }
            case ResourcesTypes::SUBSCRIPTION:
            {
                if (!empty($parameters['empty'])) {
                    return [
                        "statusCode" => Response::HTTP_NOT_FOUND,
                        "data" => []
                    ];
                } else {
                    return [
                        "statusCode" => Response::HTTP_OK,
                        "data" => [
                            "total" => 1,
                            EntityConstants::LIMIT_FIELD_KEY => 1,
                            "pages" => 1,
                            "page" => 1,
                            "results" => [
                                [
                                    EntityConstants::ID_FIELD_KEY => 1,
                                    EntityConstants::SEARCHABLE_FIELD_KEY => true,
                                    EntityConstants::PRICE_FIELD_KEY => 1
                                ],
                                [
                                    EntityConstants::ID_FIELD_KEY => 2,
                                    EntityConstants::SEARCHABLE_FIELD_KEY => true,
                                    EntityConstants::PRICE_FIELD_KEY => 0
                                ]
                            ]
                        ],
                    ];
                }
            }
            default:
                return [
                    "statusCode" => Response::HTTP_OK,
                    "data" => [
                        "total" => 1,
                        EntityConstants::LIMIT_FIELD_KEY => 1,
                        "pages" => 1,
                        "page" => 1,
                        "results" => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ]
                    ],
                ];
        }
    }

    /**
     * @param $url
     * @param $parameters
     *
     * @return array
     */
    public function post($url, $parameters = [])
    {
        return [
            "statusCode" => Response::HTTP_OK,
            "data" => []
        ];
    }
}