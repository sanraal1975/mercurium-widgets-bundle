<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\ApiClientBundle\ApiClient\ResourcesTypes;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityDynamicFieldsNormalizer;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class EntityDynamicFieldsNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers
 */
class EntityDynamicFieldsNormalizerTest extends TestCase
{
    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new EntityDynamicFieldsNormalizer();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @return void
     */
    public function testConstructThrowsTypeErrorException($fields, $field)
    {
        $this->expectException(TypeError::class);

        $normalizer = new EntityDynamicFieldsNormalizer($fields,$field);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "fields" => null,
                "field" => ""
            ],
            [
                "fields" => [
                    ResourcesTypes::ARTICLE => [
                        "0" => [
                            "image" => "image_imagen"
                        ]
                    ]
                ],
                "field" => null
            ]
        ];
    }

    /**
     * @return void
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $fields = [];
        $field = EntityConstants::FIELDS_FIELD_KEY;

        $normalizer = new EntityDynamicFieldsNormalizer($fields, $field);
        $normalizer->normalize();
    }

    /**
     * @return void
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $fields = [];
        $field = EntityConstants::FIELDS_FIELD_KEY;
        $entity = null;

        $normalizer = new EntityDynamicFieldsNormalizer($fields, $field);
        $normalizer->normalize($entity);
    }

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
                "field" => EntityConstants::FIELDS_FIELD_KEY,
                "expected" => []
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "fields" => [],
                "field" => EntityConstants::FIELDS_FIELD_KEY,
                "expected" => [EntityConstants::ID_FIELD_KEY => 1]
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "fields" => [
                    ResourcesTypes::ARTICLE => [
                        "0" => [
                            "image" => "image_imagen"
                        ]
                    ]
                ],
                "field" => "",
                "expected" => [EntityConstants::ID_FIELD_KEY => 1]
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "fields" => [
                    ResourcesTypes::ARTICLE => [
                        "0" => [
                            "image" => "image_imagen"
                        ]
                    ]
                ],
                "field" => EntityConstants::FIELDS_FIELD_KEY,
                "expected" => [EntityConstants::ID_FIELD_KEY => 1]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::FIELDS_FIELD_KEY => [
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
                "field" => EntityConstants::FIELDS_FIELD_KEY,
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "value" => 1
                        ]
                    ]
                ],
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "value" => 1
                        ]
                    ],
                    EntityConstants::TYPE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                EntityConstants::FIELDS_FIELD_KEY => [
                    "articles" => [
                        "0" => [
                            "image" => "image_imagen"
                        ]
                    ]
                ],
                "field" => EntityConstants::FIELDS_FIELD_KEY,
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "value" => 1
                        ]
                    ],
                    EntityConstants::TYPE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "values" => [
                                1
                            ]
                        ]
                    ],
                    EntityConstants::TYPE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    "resourceType" => ResourcesTypes::ARTICLE
                ],
                EntityConstants::FIELDS_FIELD_KEY => [
                    "articles" => [
                        "1" => [
                            "image" => "image_imagen"
                        ]
                    ]
                ],
                "field" => EntityConstants::FIELDS_FIELD_KEY,
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "values" => [
                                1
                            ]
                        ]
                    ],
                    EntityConstants::TYPE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    "resourceType" => ResourcesTypes::ARTICLE,
                    "image" => 1
                ],
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "values" => [
                                1
                            ]
                        ]
                    ],
                    EntityConstants::TYPE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    "resourceType" => ResourcesTypes::ARTICLE
                ],
                EntityConstants::FIELDS_FIELD_KEY => [
                    "articles" => [
                        "1" => [
                            'image' => [
                                'field' => "image_imagen",
                                'valueType' => "int",
                            ]
                        ]
                    ]
                ],
                "field" => EntityConstants::FIELDS_FIELD_KEY,
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "values" => [
                                1
                            ]
                        ]
                    ],
                    EntityConstants::TYPE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    "resourceType" => ResourcesTypes::ARTICLE,
                    "image" => 1
                ],
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "values" => [
                                1
                            ]
                        ]
                    ],
                    EntityConstants::TYPE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    "resourceType" => ResourcesTypes::ARTICLE
                ],
                EntityConstants::FIELDS_FIELD_KEY => [
                    "articles" => [
                        "1" => [
                            'loopDocuments' => [
                                'field' => "loop_documents",
                                'type' => "loop",
                            ]
                        ]
                    ]
                ],
                "field" => EntityConstants::FIELDS_FIELD_KEY,
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::FIELDS_FIELD_KEY => [
                        "image_imagen" => [
                            "values" => [
                                1
                            ]
                        ]
                    ],
                    EntityConstants::TYPE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    "resourceType" => ResourcesTypes::ARTICLE,
                    "loopDocuments" => []
                ],
            ],
        ];
    }
}