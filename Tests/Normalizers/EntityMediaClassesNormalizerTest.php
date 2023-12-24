<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityMediaClassesNormalizer;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class EntityMediaClassesNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers
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
     * @dataProvider normalize
     *
     * @param $entity
     * @param $expected
     *
     * @return void
     */
    public function testNormalize($entity, $expected)
    {
        $normalizer = new EntityMediaClassesNormalizer();
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
                "expected" => []
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_NO_IMAGE
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
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_CATEGORY . "1 " . EntityConstants::HAS_NO_IMAGE
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::IMAGE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::IMAGE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_IMAGE
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::VIDEO_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::VIDEO_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_NO_IMAGE . " " . EntityConstants::HAS_VIDEO
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::BODY_FIELD_KEY => '<figure class="m-media m-media--video m-media--editor" data-ck-asset-wrapper="">'
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::BODY_FIELD_KEY => '<figure class="m-media m-media--video m-media--editor" data-ck-asset-wrapper="">',
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_NO_IMAGE . " " . EntityConstants::HAS_VIDEO
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::AUDIO_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::AUDIO_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_AUDIO . " " . EntityConstants::HAS_NO_IMAGE
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::BODY_FIELD_KEY => '<figure class="m-media m-media--sound m-media--editor" data-ck-asset-wrapper="">'
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::BODY_FIELD_KEY => '<figure class="m-media m-media--sound m-media--editor" data-ck-asset-wrapper="">',
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_AUDIO . " " . EntityConstants::HAS_NO_IMAGE
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_RELATED_ACTIVITIES_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_RELATED_ACTIVITIES_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_ACTIVITY . " " . EntityConstants::HAS_NO_IMAGE
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_RELATED_ARTICLES_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_RELATED_ARTICLES_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_ARTICLE . " " . EntityConstants::HAS_NO_IMAGE
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_RELATED_ASSETS_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_RELATED_ASSETS_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_ASSET . " " . EntityConstants::HAS_NO_IMAGE
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_RELATED_GALLERIES_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_RELATED_GALLERIES_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_GALLERY . " " . EntityConstants::HAS_NO_IMAGE
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::BODY_FIELD_KEY => '<div class="cke-element cke-element--113">'
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::BODY_FIELD_KEY => '<div class="cke-element cke-element--113">',
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_GALLERY . " " . EntityConstants::HAS_NO_IMAGE,
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::BODY_FIELD_KEY => '<div class="cke-element cke-element--104">',
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::BODY_FIELD_KEY => '<div class="cke-element cke-element--104">',
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_NO_IMAGE . " " . EntityConstants::HAS_POLL
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_RELATED_POLLS_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_RELATED_POLLS_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_NO_IMAGE . " " . EntityConstants::HAS_POLL
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_SPONSOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::HAS_SPONSOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_NO_IMAGE . " " . EntityConstants::HAS_SPONSOR
                ]
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::SUBSCRIPTIONS_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::SUBSCRIPTIONS_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ],
                    EntityConstants::HAS_SUBSCRIPTION_FIELD_KEY => true,
                    EntityConstants::MEDIA_CLASSES_FIELD_KEY => " ".EntityConstants::HAS_NO_IMAGE . " " . EntityConstants::HAS_SUBSCRIPTION
                ]
            ]
        ];
    }
}