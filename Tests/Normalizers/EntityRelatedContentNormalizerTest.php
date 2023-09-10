<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\ApiClientBundle\ApiClient\ResourcesTypes;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\ActivityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\GalleryNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\PollNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAuthorNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityRelatedContentNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class EntityRelatedContentNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers
 */
class EntityRelatedContentNormalizerTest extends TestCase
{
    const BASE_EXPECTED_ENTITY = [
        EntityConstants::ID_FIELD_KEY => 1,
        EntityConstants::HAS_RELATED_CONTENT_FIELD_KEY => false,
        EntityConstants::HAS_RELATED_ACTIVITIES_FIELD_KEY => false,
        EntityConstants::RELATED_ACTIVITIES_FIELD_KEY => [],
        EntityConstants::HAS_RELATED_ARTICLES_FIELD_KEY => false,
        EntityConstants::RELATED_ARTICLES_FIELD_KEY => [],
        EntityConstants::HAS_RELATED_ASSETS_FIELD_KEY => false,
        EntityConstants::RELATED_ASSETS_FIELD_KEY => [],
        EntityConstants::HAS_RELATED_GALLERIES_FIELD_KEY => false,
        EntityConstants::RELATED_GALLERIES_FIELD_KEY => [],
        EntityConstants::HAS_RELATED_POLLS_FIELD_KEY => false,
        EntityConstants::RELATED_POLLS_FIELD_KEY => [],
    ];

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
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        new EntityRelatedContentNormalizer();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @param $api
     * @param $activityNormalizer
     * @param $articleNormalizer
     * @param $assetNormalizer
     * @param $galleryNormalizer
     * @param $pollNormalizer
     *
     * @return void
     */
    public function testConstructThrowsTypeErrorException($api, $activityNormalizer, $articleNormalizer, $assetNormalizer, $galleryNormalizer, $pollNormalizer)
    {
        $this->expectException(TypeError::class);

        new EntityRelatedContentNormalizer($api, $activityNormalizer, $articleNormalizer, $assetNormalizer, $galleryNormalizer, $pollNormalizer);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "api" => null,
                "activityNormalizer" => null,
                "articleNormalizer" => null,
                "assetNormalizer" => null,
                "galleryNormalizer" => null,
                "pollNormalizer" => null
            ],
            [
                "api" => $this->api,
                "activityNormalizer" => "",
                "articleNormalizer" => null,
                "assetNormalizer" => null,
                "galleryNormalizer" => null,
                "pollNormalizer" => null
            ],
            [
                "api" => $this->api,
                "activityNormalizer" => null,
                "articleNormalizer" => "",
                "assetNormalizer" => null,
                "galleryNormalizer" => null,
                "pollNormalizer" => null
            ],
            [
                "api" => $this->api,
                "activityNormalizer" => null,
                "articleNormalizer" => null,
                "assetNormalizer" => "",
                "galleryNormalizer" => null,
                "pollNormalizer" => null
            ],
            [
                "api" => $this->api,
                "activityNormalizer" => null,
                "articleNormalizer" => null,
                "assetNormalizer" => null,
                "galleryNormalizer" => "",
                "pollNormalizer" => null
            ],
            [
                "api" => $this->api,
                "activityNormalizer" => null,
                "articleNormalizer" => null,
                "assetNormalizer" => null,
                "galleryNormalizer" => null,
                "pollNormalizer" => ""
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new EntityRelatedContentNormalizer($this->api);
        $normalizer->normalize();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $entity = "";
        $normalizer = new EntityRelatedContentNormalizer($this->api);
        $normalizer->normalize($entity);
    }

    /**
     * @dataProvider normalize
     *
     * @param $entity
     * @param $expected
     *
     * @return void
     * @throws Exception
     */
    public function testNormalize($entity, $expected)
    {
        $normalizer = new EntityRelatedContentNormalizer($this->api);
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
                "expected" => [],
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "expected" => self::BASE_EXPECTED_ENTITY,
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1,
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [EntityConstants::RELATED_CONTENT_FIELD_KEY => []]
                ),
            ]
        ];
    }

    /**
     * @dataProvider normalizeActivities
     *
     * @param $entity
     * @param $expected
     * @param $activityNormalizer
     * @return void
     * @throws Exception
     */
    public function testNormalizeActivities($entity, $expected, $activityNormalizer)
    {
        $normalizer = new EntityRelatedContentNormalizer($this->api, $activityNormalizer);
        $result = $normalizer->normalize($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function normalizeActivities(): array
    {
        $activityNormalizer = new ActivityNormalizer(
            new EntityNormalizer(
                [
                    new EntityAuthorNormalizer($this->api)
                ]
            )
        );

        return [
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::ACTIVITY
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [EntityConstants::RELATED_CONTENT_FIELD_KEY => []]
                ),
                "activityNormalizer" => $activityNormalizer,
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::ACTIVITY
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [],
                    ]
                ),
                "activityNormalizer" => $activityNormalizer,
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::ACTIVITY
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::HAS_RELATED_CONTENT_FIELD_KEY => true,
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ],
                        EntityConstants::HAS_RELATED_ACTIVITIES_FIELD_KEY => true,
                        EntityConstants::RELATED_ACTIVITIES_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ]
                    ]
                ),
                "activityNormalizer" => null,
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::ACTIVITY
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::HAS_RELATED_CONTENT_FIELD_KEY => true,
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ],
                        EntityConstants::HAS_RELATED_ACTIVITIES_FIELD_KEY => true,
                        EntityConstants::RELATED_ACTIVITIES_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ]
                    ]
                ),
                "activityNormalizer" => $activityNormalizer,
            ],
        ];
    }

    /**
     * @dataProvider normalizeArticles
     *
     * @param $entity
     * @param $expected
     * @param $articleNormalizer
     * @return void
     * @throws Exception
     */
    public function testNormalizeArticles($entity, $expected, $articleNormalizer)
    {
        $normalizer = new EntityRelatedContentNormalizer($this->api, null, $articleNormalizer);
        $result = $normalizer->normalize($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function normalizeArticles(): array
    {
        $articleNormalizer = new EntityNormalizer(
            [
                new EntityAuthorNormalizer($this->api)
            ]
        );

        return [
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::ARTICLE
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [EntityConstants::RELATED_CONTENT_FIELD_KEY => []]
                ),
                "articleNormalizer" => $articleNormalizer,
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::ARTICLE
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [],
                    ]
                ),
                "articleNormalizer" => $articleNormalizer,
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::ARTICLE
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::HAS_RELATED_CONTENT_FIELD_KEY => true,
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ],
                        EntityConstants::HAS_RELATED_ARTICLES_FIELD_KEY => true,
                        EntityConstants::RELATED_ARTICLES_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ]
                    ]
                ),
                "articleNormalizer" => null,
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::ARTICLE
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::HAS_RELATED_CONTENT_FIELD_KEY => true,
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ],
                        EntityConstants::HAS_RELATED_ARTICLES_FIELD_KEY => true,
                        EntityConstants::RELATED_ARTICLES_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ]
                    ]
                ),
                "articleNormalizer" => $articleNormalizer,
            ],
        ];
    }

    /**
     * @dataProvider normalizeAssets
     *
     * @param $entity
     * @param $expected
     * @param $assetNormalizer
     * @return void
     * @throws Exception
     */
    public function testNormalizeAssets($entity, $expected, $assetNormalizer)
    {
        $normalizer = new EntityRelatedContentNormalizer($this->api, null, null, $assetNormalizer);
        $result = $normalizer->normalize($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function normalizeAssets(): array
    {
        $assetNormalizer = new EntityNormalizer(
            [
                new EntityAuthorNormalizer($this->api)
            ]
        );

        return [
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::ASSET
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [EntityConstants::RELATED_CONTENT_FIELD_KEY => []]
                ),
                "assetNormalizer" => $assetNormalizer,
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::ASSET
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [],
                    ]
                ),
                "assetNormalizer" => $assetNormalizer
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::ASSET
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::HAS_RELATED_CONTENT_FIELD_KEY => true,
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ],
                        EntityConstants::HAS_RELATED_ASSETS_FIELD_KEY => true,
                        EntityConstants::RELATED_ASSETS_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ]
                    ]
                ),
                "assetNormalizer" => null
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::ASSET
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::HAS_RELATED_CONTENT_FIELD_KEY => true,
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ],
                        EntityConstants::HAS_RELATED_ASSETS_FIELD_KEY => true,
                        EntityConstants::RELATED_ASSETS_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ]
                    ]
                ),
                "assetNormalizer" => $assetNormalizer
            ],
        ];
    }

    /**
     * @dataProvider normalizeGalleries
     *
     * @param $entity
     * @param $expected
     * @param $galleryNormalizer
     * @return void
     * @throws Exception
     */
    public function testNormalizeGalleries($entity, $expected, $galleryNormalizer)
    {
        $normalizer = new EntityRelatedContentNormalizer($this->api, null, null, null, $galleryNormalizer);
        $result = $normalizer->normalize($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function normalizeGalleries(): array
    {
        $galleryNormalizer = new GalleryNormalizer($this->api);

        return [
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::GALLERY
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [EntityConstants::RELATED_CONTENT_FIELD_KEY => []]
                ),
                "galleryNormalizer" => $galleryNormalizer,
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::GALLERY
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [],
                    ]
                ),
                "galleryNormalizer" => $galleryNormalizer
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::GALLERY
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::HAS_RELATED_CONTENT_FIELD_KEY => true,
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ],
                        EntityConstants::HAS_RELATED_GALLERIES_FIELD_KEY => true,
                        EntityConstants::RELATED_GALLERIES_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ]
                    ]
                ),
                "galleryNormalizer" => null
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::GALLERY
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::HAS_RELATED_CONTENT_FIELD_KEY => true,
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true,
                                EntityConstants::TOTAL_ASSETS_FIELD_KEY => 0
                            ]
                        ],
                        EntityConstants::HAS_RELATED_GALLERIES_FIELD_KEY => true,
                        EntityConstants::RELATED_GALLERIES_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true,
                                EntityConstants::TOTAL_ASSETS_FIELD_KEY => 0
                            ]
                        ]
                    ]
                ),
                "galleryNormalizer" => $galleryNormalizer
            ],
        ];
    }

    /**
     * @dataProvider normalizePolls
     *
     * @param $entity
     * @param $expected
     * @param $pollNormalizer
     * @return void
     * @throws Exception
     */
    public function testNormalizePolls($entity, $expected, $pollNormalizer)
    {
        $normalizer = new EntityRelatedContentNormalizer($this->api, null, null, null, null, $pollNormalizer);
        $result = $normalizer->normalize($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function normalizePolls(): array
    {
        $pollNormalizer = new PollNormalizer();

        return [
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::POLL
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [EntityConstants::RELATED_CONTENT_FIELD_KEY => []]
                ),
                "pollNormalizer" => $pollNormalizer,
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::POLL
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [],
                    ]
                ),
                "pollNormalizer" => $pollNormalizer
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::POLL
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::HAS_RELATED_CONTENT_FIELD_KEY => true,
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ],
                        EntityConstants::HAS_RELATED_POLLS_FIELD_KEY => true,
                        EntityConstants::RELATED_POLLS_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true
                            ]
                        ]
                    ]
                ),
                "pollNormalizer" => null
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::TYPE_FIELD_KEY => ResourcesTypes::POLL
                        ]
                    ]
                ],
                "expected" => array_merge(
                    self::BASE_EXPECTED_ENTITY,
                    [
                        EntityConstants::HAS_RELATED_CONTENT_FIELD_KEY => true,
                        EntityConstants::RELATED_CONTENT_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true,
                            ]
                        ],
                        EntityConstants::HAS_RELATED_POLLS_FIELD_KEY => true,
                        EntityConstants::RELATED_POLLS_FIELD_KEY => [
                            [
                                EntityConstants::ID_FIELD_KEY => 1,
                                EntityConstants::SEARCHABLE_FIELD_KEY => true,
                            ]
                        ]
                    ]
                ),
                "pollNormalizer" => $pollNormalizer
            ],
        ];
    }
}