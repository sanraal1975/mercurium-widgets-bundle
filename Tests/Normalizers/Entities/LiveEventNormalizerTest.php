<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\ApiClient\ResourcesTypes;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\LiveEventNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class LiveEventNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities
 */
class LiveEventNormalizerTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @var ClientMock
     */
    private $api;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);
        $this->testHelper = new TestHelper();

        $this->api = $this->testHelper->getApi();
    }

    /**
     * @dataProvider constructThrowsArgumentCountErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsArgumentCountErrorException($api, $fields)
    {
        $this->expectException(ArgumentCountError::class);

        if (empty($api)) {
            $normalizer = new LiveEventNormalizer();
        } else {
            if (empty($fields)) {
                $normalizer = new LiveEventNormalizer($api);
            }
        }
    }

    /**
     * @return array
     */
    public function constructThrowsArgumentCountErrorException(): array
    {
        return [
            [
                "api" => null,
                "fields" => null
            ],
            [
                "api" => $this->api,
                "fields" => null
            ]
        ];
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @param $api
     * @param $fields
     * @param $fieldsKey
     * @param $assetFieldKey
     * @param $localShieldKey
     * @param $visitorShieldKey
     * @param $authorAssetNormalizer
     *
     * @return void
     */
    public function testConstructThrowsTypeErrorException(
        $api,
        $fields,
        $fieldsKey,
        $assetFieldKey,
        $localShieldKey,
        $visitorShieldKey,
        $authorAssetNormalizer
    )
    {
        $this->expectException(TypeError::class);

        $normalizer = new LiveEventNormalizer(
            $api,
            $fields,
            $fieldsKey,
            $assetFieldKey,
            $localShieldKey,
            $visitorShieldKey,
            $authorAssetNormalizer
        );
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "api" => null,
                "fields" => null,
                "fieldsKey" => null,
                "assetFieldKey" => null,
                "localShieldKey" => null,
                "visitorShieldKey" => null,
                "authorAssetNormalizer" => ""
            ],
            [
                "api" => $this->api,
                "fields" => null,
                "fieldsKey" => null,
                "assetFieldKey" => null,
                "localShieldKey" => null,
                "visitorShieldKey" => null,
                "authorAssetNormalizer" => ""
            ],
            [
                "api" => $this->api,
                "fields" => [],
                "fieldsKey" => EntityConstants::FIELDS_FIELD_KEY,
                "assetFieldKey" => null,
                "localShieldKey" => null,
                "visitorShieldKey" => null,
                "authorAssetNormalizer" => ""
            ],
            [
                "api" => $this->api,
                "fields" => [],
                "fieldsKey" => EntityConstants::FIELDS_FIELD_KEY,
                "assetFieldKey" => EntityConstants::ASSET_FIELD_KEY,
                "localShieldKey" => null,
                "visitorShieldKey" => null,
                "authorAssetNormalizer" => ""
            ],
            [
                "api" => $this->api,
                "fields" => [],
                "fieldsKey" => EntityConstants::FIELDS_FIELD_KEY,
                "assetFieldKey" => EntityConstants::ASSET_FIELD_KEY,
                "localShieldKey" => EntityConstants::LOCAL_SHIELD_FIELD_KEY,
                "visitorShieldKey" => null,
                "authorAssetNormalizer" => ""
            ],
            [
                "api" => $this->api,
                "fields" => [],
                "fieldsKey" => EntityConstants::FIELDS_FIELD_KEY,
                "assetFieldKey" => EntityConstants::ASSET_FIELD_KEY,
                "localShieldKey" => EntityConstants::LOCAL_SHIELD_FIELD_KEY,
                "visitorShieldKey" => EntityConstants::VISITOR_SHIELD_FIELD_KEY,
                "authorAssetNormalizer" => ""
            ]
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new LiveEventNormalizer($this->api, []);

        $entity = $normalizer->normalize();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new LiveEventNormalizer();

        $entity = null;
        $entity = $normalizer->normalize($entity);
    }

    /**
     * @dataProvider normalize
     *
     * @param $entity
     * @param $fields
     * @param $expected
     *
     * @return void
     * @throws Exception
     */
    public function testNormalize($entity, $fields, $expected)
    {
        $normalizer = new LiveEventNormalizer($this->api, $fields);
        $result = $normalizer->normalize($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function normalize(): array
    {
        return [
            [
                "entity" => [],
                "fields" => [],
                "expected" => []
            ],
            [
                "entity" => [
                    'resourceType' => ResourcesTypes::LIVE_EVENT,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "short_text_autor_lliure" => [
                            "values" => ["entity_free_author"]
                        ]
                    ]
                ],
                "fields" => [
                    ResourcesTypes::LIVE_EVENT => [
                        "freeAuthor" => "short_text_autor_lliure"
                    ]
                ],
                "expected" => [
                    'resourceType' => ResourcesTypes::LIVE_EVENT,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "short_text_autor_lliure" => [
                            "values" => ["entity_free_author"]
                        ]
                    ],
                    "freeAuthor" => "entity_free_author"
                ]
            ],
            [
                "entity" => [
                    'resourceType' => ResourcesTypes::LIVE_EVENT,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_image" => [
                            "values" => [1]
                        ]
                    ]
                ],
                "fields" => [
                    ResourcesTypes::LIVE_EVENT => [
                        EntityConstants::IMAGE_FIELD_KEY => [
                            "field" => "image_image",
                            "valueType" => "int"
                        ]
                    ]
                ],
                "expected" => [
                    'resourceType' => ResourcesTypes::LIVE_EVENT,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_image" => [
                            "values" => [1]
                        ]
                    ],
                    EntityConstants::IMAGE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        EntityConstants::ORIENTATION_FIELD_KEY => "is-square"
                    ]
                ]
            ],
            [
                "entity" => [
                    'resourceType' => ResourcesTypes::LIVE_EVENT,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_escut_local" => [
                            "values" => [1]
                        ]
                    ]
                ],
                "fields" => [
                    ResourcesTypes::LIVE_EVENT => [
                        EntityConstants::LOCAL_SHIELD_FIELD_KEY => [
                            "field" => "image_escut_local",
                            "valueType" => "int"
                        ]
                    ]
                ],
                "expected" => [
                    'resourceType' => ResourcesTypes::LIVE_EVENT,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_escut_local" => [
                            "values" => [1]
                        ]
                    ],
                    EntityConstants::LOCAL_SHIELD_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        EntityConstants::ORIENTATION_FIELD_KEY => "is-square"
                    ]
                ]
            ],
            [
                "entity" => [
                    'resourceType' => ResourcesTypes::LIVE_EVENT,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_escut_visitant" => [
                            "values" => [1]
                        ]
                    ]
                ],
                "fields" => [
                    ResourcesTypes::LIVE_EVENT => [
                        EntityConstants::VISITOR_SHIELD_FIELD_KEY => [
                            "field" => "image_escut_visitant",
                            "valueType" => "int"
                        ]
                    ]
                ],
                "expected" => [
                    'resourceType' => ResourcesTypes::LIVE_EVENT,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_escut_visitant" => [
                            "values" => [1]
                        ]
                    ],
                    EntityConstants::VISITOR_SHIELD_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        EntityConstants::ORIENTATION_FIELD_KEY => EntityConstants::IMAGE_ORIENTATION_SQUARE
                    ]
                ]
            ],
            [
                "entity" => [
                    'resourceType' => ResourcesTypes::LIVE_EVENT,
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                ],
                "fields" => [],
                "expected" => [
                    'resourceType' => ResourcesTypes::LIVE_EVENT,
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                    ]
                ]
            ]
        ];
    }
}