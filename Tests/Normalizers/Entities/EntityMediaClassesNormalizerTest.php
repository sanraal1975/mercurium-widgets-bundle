<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Tests\TestCase;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
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
                    BundleConstants::ID_FIELD_KEY => 1
                ],
                "expected" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::MEDIA_CLASSES_FIELD_KEY => BundleConstants::HAS_NO_IMAGE
                ]
            ],
            [
                "entity" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::CATEGORIES_FIELD_KEY => [
                        [
                            BundleConstants::ID_FIELD_KEY => 1
                        ]
                    ]
                ],
                "expected" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::CATEGORIES_FIELD_KEY => [
                        [
                            BundleConstants::ID_FIELD_KEY => 1
                        ]
                    ],
                    BundleConstants::MEDIA_CLASSES_FIELD_KEY => BundleConstants::HAS_CATEGORY . "1 " . BundleConstants::HAS_NO_IMAGE
                ]
            ],
            [
                "entity" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    "image" => [
                        BundleConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    "image" => [
                        BundleConstants::ID_FIELD_KEY => 1
                    ],
                    BundleConstants::MEDIA_CLASSES_FIELD_KEY => BundleConstants::HAS_IMAGE
                ]
            ],
            [
                "entity" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    "video" => [
                        BundleConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    "video" => [
                        BundleConstants::ID_FIELD_KEY => 1
                    ],
                    BundleConstants::MEDIA_CLASSES_FIELD_KEY => BundleConstants::HAS_NO_IMAGE . " " . BundleConstants::HAS_VIDEO
                ]
            ],
            [
                "entity" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    "audio" => [
                        BundleConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    "audio" => [
                        BundleConstants::ID_FIELD_KEY => 1
                    ],
                    BundleConstants::MEDIA_CLASSES_FIELD_KEY => BundleConstants::HAS_NO_IMAGE . " " . BundleConstants::HAS_AUDIO
                ]
            ],
        ];
    }
}