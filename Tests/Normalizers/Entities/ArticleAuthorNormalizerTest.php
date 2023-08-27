<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Tests\TestCase;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\ArticleAuthorNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use TypeError;

/**
 * Class ArticleAuthorNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities
 */
class ArticleAuthorNormalizerTest extends TestCase
{
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

        $testHelper = new TestHelper();
        $this->api = $testHelper->getApi();
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new ArticleAuthorNormalizer();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @return void
     */
    public function testConstructThrowsTypeErrorException($api, $normalizeImage, $normalizeSocialNetworks, $bannedSocialNetworks)
    {
        $this->expectException(TypeError::class);

        $normalizer = new ArticleAuthorNormalizer($api, $normalizeImage, $normalizeSocialNetworks, $bannedSocialNetworks);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "api" => null,
                "normalizeImage" => true,
                "normalizeSocialNetworks" => false,
                "bannedSocialNetworks" => [],
            ],
            [
                "api" => $this->api,
                "normalizeImage" => null,
                "normalizeSocialNetworks" => false,
                "bannedSocialNetworks" => [],
            ],
            [
                "api" => $this->api,
                "normalizeImage" => true,
                "normalizeSocialNetworks" => null,
                "bannedSocialNetworks" => [],
            ],
            [
                "api" => $this->api,
                "normalizeImage" => true,
                "normalizeSocialNetworks" => true,
                "bannedSocialNetworks" => null,
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

        $normalizer = new ArticleAuthorNormalizer($this->api);
        $result = $normalizer->normalize();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new ArticleAuthorNormalizer($this->api);
        $entity = null;
        $result = $normalizer->normalize($entity);
    }

    /**
     * @dataProvider normalizeReturnsEntity
     * @param $normalizeImage
     * @param $normalizeSocialNetworks
     * @param $bannedSocialNetworks
     * @param $entity
     * @param $expected
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEntity($normalizeImage, $normalizeSocialNetworks, $bannedSocialNetworks, $entity, $expected)
    {
        $normalizer = new ArticleAuthorNormalizer($this->api, $normalizeImage, $normalizeSocialNetworks, $bannedSocialNetworks);
        $result = $normalizer->normalize($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function normalizeReturnsEntity(): array
    {
        return [
            [
                "normalizeImage" => false,
                "normalizeSocialNetworks" => false,
                "bannedSocialNetworks" => [],
                "entity" => [],
                "expected" => []
            ],
            [
                "normalizeImage" => false,
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
                "normalizeImage" => true,
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
                "normalizeImage" => true,
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
                "normalizeImage" => false,
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
                "normalizeImage" => false,
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
                "normalizeImage" => false,
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