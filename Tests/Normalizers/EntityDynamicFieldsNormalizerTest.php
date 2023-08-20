<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use Comitium5\ApiClientBundle\ApiClient\ResourcesTypes;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityDynamicFieldsNormalizer;
use PHPUnit\Framework\TestCase;

/**
 * Class EntityDynamicFieldsNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers
 */
class EntityDynamicFieldsNormalizerTest extends TestCase
{
    /**
     * @dataProvider normalizeReturnInputEntity
     *
     * @return void
     */
    public function testNormalizeReturnInputEntity($entity, $fields, $field, $expected)
    {
        $normalizer = new EntityDynamicFieldsNormalizer($fields, $field);

        $result = $normalizer->normalize($entity);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function normalizeReturnInputEntity(): array
    {
        return [
            [
                "entity" => [],
                "fields" => [],
                "field" => BundleConstants::FIELDS_FIELD_KEY,
                "expected" => []
            ],
            [
                "entity" => [BundleConstants::ID_FIELD_KEY => 1],
                "fields" => [],
                "field" => BundleConstants::FIELDS_FIELD_KEY,
                "expected" => [BundleConstants::ID_FIELD_KEY => 1]
            ],
            [
                "entity" => [BundleConstants::ID_FIELD_KEY => 1],
                "fields" => [
                    ResourcesTypes::ARTICLE => [
                        "0" => [
                            "image" => "image_imagen"
                        ]
                    ]
                ],
                "field" => "",
                "expected" => [BundleConstants::ID_FIELD_KEY => 1]
            ],
            [
                "entity" => [BundleConstants::ID_FIELD_KEY => 1],
                "fields" => [
                    ResourcesTypes::ARTICLE => [
                        "0" => [
                            "image" => "image_imagen"
                        ]
                    ]
                ],
                "field" => BundleConstants::FIELDS_FIELD_KEY,
                "expected" => [BundleConstants::ID_FIELD_KEY => 1]
            ],
            [
                "entity" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "value" => 1
                        ]
                    ]
                ],
                "fields" => [
                    ResourcesTypes::ARTICLE => [
                        "0" => [
                            "image" => "image_imagen"
                        ]
                    ]
                ],
                "field" => BundleConstants::FIELDS_FIELD_KEY,
                "expected" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "value" => 1
                        ]
                    ]
                ],
            ],
            [
                "entity" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "value" => 1
                        ]
                    ],
                    BundleConstants::TYPE_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => 1
                    ]
                ],
                BundleConstants::FIELDS_FIELD_KEY => [
                    "articles" => [
                        "0" => [
                            "image" => "image_imagen"
                        ]
                    ]
                ],
                "field" => BundleConstants::FIELDS_FIELD_KEY,
                "expected" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "value" => 1
                        ]
                    ],
                    BundleConstants::TYPE_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => 1
                    ]
                ],
            ],
            [
                "entity" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "value" => 1
                        ]
                    ],
                    BundleConstants::TYPE_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => 1
                    ],
                    "resourceType" => ResourcesTypes::ARTICLE
                ],
                BundleConstants::FIELDS_FIELD_KEY => [
                    "articles" => [
                        "1" => [
                            "image" => "image_imagen"
                        ]
                    ]
                ],
                "field" => BundleConstants::FIELDS_FIELD_KEY,
                "expected" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "value" => 1
                        ]
                    ],
                    BundleConstants::TYPE_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => 1
                    ],
                    "resourceType" => ResourcesTypes::ARTICLE
                ],
            ],
        ];
    }
}