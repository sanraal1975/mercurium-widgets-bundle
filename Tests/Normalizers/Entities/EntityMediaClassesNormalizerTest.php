<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Tests\TestCase;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityMediaClassesNormalizer;
use Exception;
use TypeError;

/**
 * Class EntityMediaClassesNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities
 */
class EntityMediaClassesNormalizerTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new EntityMediaClassesNormalizer();
        $result = $normalizer->normalize();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new EntityMediaClassesNormalizer();
        $entity = null;
        $result = $normalizer->normalize($entity);
    }

    /**
     * @dataProvider normalizeReturnEntity
     *
     * @param $entity
     * @param $expected
     *
     * @return void
     */
    public function testNormalizeReturnEntity($entity, $expected)
    {
        $normalizer = new EntityMediaClassesNormalizer();
        $result = $normalizer->normalize($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function normalizeReturnEntity(): array
    {
        return [
            [
                "entity" => [],
                "expected" => []
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => EntityConstants::HAS_NO_IMAGE
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::CATEGORIES_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1
                        ]
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::CATEGORIES_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1
                        ]
                    ],
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => EntityConstants::HAS_CATEGORY . "1 " . EntityConstants::HAS_NO_IMAGE
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    "image" => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    "image" => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => EntityConstants::HAS_IMAGE
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    "video" => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    "video" => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => EntityConstants::HAS_NO_IMAGE . " " . EntityConstants::HAS_VIDEO
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    "audio" => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    "audio" => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => EntityConstants::HAS_NO_IMAGE . " " . EntityConstants::HAS_AUDIO
                ]
            ],
        ];
    }
}