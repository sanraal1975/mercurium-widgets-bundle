<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AuthorHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAssetNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAuthorNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class EntityAuthorNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers
 */
class EntityAuthorNormalizerTest extends TestCase
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
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        new EntityAuthorNormalizer();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @param $api
     * @param $field
     * @param $assetNormalizer
     * @param $normalizeSocialNetworks
     * @param $bannedSocialNetworks
     *
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException($api, $field, $assetNormalizer, $normalizeSocialNetworks, $bannedSocialNetworks)
    {
        $this->expectException(TypeError::class);

        new EntityAuthorNormalizer($api, $field, $assetNormalizer, $normalizeSocialNetworks, $bannedSocialNetworks);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function constructThrowsTypeErrorException(): array
    {
        $assetNormalizer = new EntityNormalizer(
            [
                new EntityAssetNormalizer($this->api, EntityConstants::ASSET_FIELD_KEY)
            ]
        );

        return [
            [
                "api" => null,
                "field" => null,
                "assetNormalizer" => null,
                "normalizeSocialNetworks" => null,
                "bannedSocialNetworks" => null
            ],
            [
                "api" => $this->api,
                "field" => null,
                "assetNormalizer" => null,
                "normalizeSocialNetworks" => null,
                "bannedSocialNetworks" => null
            ],
            [
                "api" => $this->api,
                "field" => EntityConstants::AUTHOR_FIELD_KEY,
                "assetNormalizer" => "",
                "normalizeSocialNetworks" => null,
                "bannedSocialNetworks" => null
            ],
            [
                "api" => $this->api,
                "field" => EntityConstants::AUTHOR_FIELD_KEY,
                "assetNormalizer" => $assetNormalizer,
                "normalizeSocialNetworks" => null,
                "bannedSocialNetworks" => null
            ],
            [
                "api" => $this->api,
                "field" => EntityConstants::AUTHOR_FIELD_KEY,
                "assetNormalizer" => $assetNormalizer,
                "normalizeSocialNetworks" => false,
                "bannedSocialNetworks" => null
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageEmptyField()
    {
        $this->expectExceptionMessage(EntityAuthorNormalizer::EMPTY_FIELD);

        new EntityAuthorNormalizer($this->api, "");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new EntityAuthorNormalizer($this->api);
        $normalizer->normalize();
    }

    /**
     * @dataProvider normalizeThrowsTypeErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException($entity)
    {
        $this->expectException(TypeError::class);

        $normalizer = new EntityAuthorNormalizer($this->api);

        $normalizer->normalize($entity);
    }

    /**
     * @return array
     */
    public function normalizeThrowsTypeErrorException(): array
    {
        return [
            [
                "parameter" => 1,
            ],
            [
                "parameter" => null,
            ],
        ];
    }

    /**
     * @dataProvider normalizeReturnInputEntity
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnInputEntity(array $entity)
    {
        $normalizer = new EntityAuthorNormalizer($this->api);
        $result = $normalizer->normalize($entity);

        $this->assertEquals($entity, $result);
    }

    /**
     * @return array[]
     */
    public function normalizeReturnInputEntity(): array
    {
        return [
            [
                "entity" => [],
            ],
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => []],
            ],
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => 0],
            ],
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => null],
            ],
            [
                "entity" => [TestHelper::IMAGE_FIELD_KEY => []],
            ],
        ];
    }

    /**
     * @dataProvider normalizeThrowsExceptionMessageNonNumericAuthorId
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsExceptionMessageNonNumericAuthorId($entity)
    {
        $this->expectExceptionMessage(EntityAuthorNormalizer::NON_NUMERIC_AUTHOR_ID);

        $normalizer = new EntityAuthorNormalizer($this->api);
        $normalizer->normalize($entity);
    }

    /**
     * @return array[]
     */
    public function normalizeThrowsExceptionMessageNonNumericAuthorId(): array
    {
        return [
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => [EntityConstants::ID_FIELD_KEY => "a"]]
            ],
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => [EntityConstants::ID_FIELD_KEY => null]]
            ],
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => [EntityConstants::ID_FIELD_KEY => []]]
            ],
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => EntityConstants::ID_FIELD_KEY]
            ],
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => ["title"]]
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsExceptionMessageEntityIdGreaterThanZero()
    {
        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $entity = ["author" => [EntityConstants::ID_FIELD_KEY => $this->testHelper->getZeroOrNegativeValue()]];

        $normalizer = new EntityAuthorNormalizer($this->api);
        $normalizer->normalize($entity);
    }

    /**
     * @dataProvider normalizeReturnsEntityAuthorNormalized
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEntityAuthorNormalized($imageNormalizer, $normalizeSocialNetworks, $bannedSocialNetworks, $entity, $expected)
    {
        $normalizer = new EntityAuthorNormalizer($this->api, EntityConstants::AUTHOR_FIELD_KEY, $imageNormalizer, $normalizeSocialNetworks, $bannedSocialNetworks);

        $result = $normalizer->normalize($entity);
        $this->assertEquals($expected, $result);
    }

    /**
     *
     * @return array[]
     * @throws Exception
     */
    public function normalizeReturnsEntityAuthorNormalized(): array
    {
        $assetNormalizer = new EntityNormalizer(
            [
                new EntityAssetNormalizer($this->api, EntityConstants::ASSET_FIELD_KEY)
            ]
        );

        return [
            [
                "imageNormalizer" => null,
                "normalizeSocialNetworks" => false,
                "bannedSocialNetworks" => [],
                "entity" => [EntityConstants::ID_FIELD_KEY => 1, "author" => [EntityConstants::ID_FIELD_KEY => 1]],
                "expected" => [EntityConstants::ID_FIELD_KEY => 1, "author" => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::SEARCHABLE_FIELD_KEY => true]],
            ],
            [
                "imageNormalizer" => null,
                "normalizeSocialNetworks" => false,
                "bannedSocialNetworks" => [],
                "entity" => [EntityConstants::ID_FIELD_KEY => 1, "author" => [EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY]],
                "expected" => [EntityConstants::ID_FIELD_KEY => 1, "author" => []],
            ],
            [
                "imageNormalizer" => null,
                "normalizeSocialNetworks" => false,
                "bannedSocialNetworks" => [],
                "entity" => [],
                "expected" => []
            ],
            [
                "imageNormalizer" => null,
                "normalizeSocialNetworks" => false,
                "bannedSocialNetworks" => [],
                "entity" => [
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ],
            ],
            [
                "imageNormalizer" => $assetNormalizer,
                "normalizeSocialNetworks" => false,
                "bannedSocialNetworks" => [],
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        EntityConstants::ASSET_FIELD_KEY => [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::SEARCHABLE_FIELD_KEY => true
                        ]
                    ]
                ]
            ],
            [
                "imageNormalizer" => $assetNormalizer,
                "normalizeSocialNetworks" => true,
                "bannedSocialNetworks" => [],
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        EntityConstants::ASSET_FIELD_KEY => [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::SEARCHABLE_FIELD_KEY => true
                        ]
                    ]
                ],
            ],
            [
                "imageNormalizer" => null,
                "normalizeSocialNetworks" => true,
                "bannedSocialNetworks" => [],
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORKS
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORKS,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        EntityConstants::SOCIAL_NETWORKS_FIELD_KEY => [
                            [
                                "socialNetwork" => "facebook",
                                "url" => "https://www.foo.bar"
                            ]
                        ]
                    ]
                ],
            ],
            [
                "imageNormalizer" => null,
                "normalizeSocialNetworks" => true,
                "bannedSocialNetworks" => [],
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORK_WITH_EMPTY_URL
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORK_WITH_EMPTY_URL,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        EntityConstants::SOCIAL_NETWORKS_FIELD_KEY => []
                    ]
                ],
            ],
            [
                "imageNormalizer" => null,
                "normalizeSocialNetworks" => true,
                "bannedSocialNetworks" => ["banned_social_network"],
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_BANNED_SOCIALNETWORK
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::AUTHOR_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_BANNED_SOCIALNETWORK,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        EntityConstants::SOCIAL_NETWORKS_FIELD_KEY => []
                    ]
                ],
            ],

        ];
    }
}