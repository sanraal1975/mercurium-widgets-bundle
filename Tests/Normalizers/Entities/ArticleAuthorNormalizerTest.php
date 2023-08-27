<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Tests\TestCase;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
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
                    BundleConstants::AUTHOR_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => [
                    BundleConstants::AUTHOR_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => 1,
                        BundleConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ],
            ],
            [
                "normalizeImage" => true,
                "normalizeSocialNetworks" => false,
                "bannedSocialNetworks" => [],
                "entity" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::AUTHOR_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET
                    ]
                ],
                "expected" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::AUTHOR_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET,
                        BundleConstants::SEARCHABLE_FIELD_KEY => true,
                        BundleConstants::ASSET_FIELD_KEY => [
                            BundleConstants::ID_FIELD_KEY => 1,
                            BundleConstants::SEARCHABLE_FIELD_KEY => true
                        ]
                    ]
                ]
            ],
            [
                "normalizeImage" => true,
                "normalizeSocialNetworks" => true,
                "bannedSocialNetworks" => [],
                "entity" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::AUTHOR_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET
                    ]
                ],
                "expected" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::AUTHOR_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET,
                        BundleConstants::SEARCHABLE_FIELD_KEY => true,
                        BundleConstants::ASSET_FIELD_KEY => [
                            BundleConstants::ID_FIELD_KEY => 1,
                            BundleConstants::SEARCHABLE_FIELD_KEY => true
                        ]
                    ]
                ],
            ],
            [
                "normalizeImage" => false,
                "normalizeSocialNetworks" => true,
                "bannedSocialNetworks" => [],
                "entity" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::AUTHOR_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORKS
                    ]
                ],
                "expected" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::AUTHOR_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORKS,
                        BundleConstants::SEARCHABLE_FIELD_KEY => true,
                        BundleConstants::SOCIAL_NETWORKS_FIELD_KEY => [
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
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::AUTHOR_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORK_WITH_EMPTY_URL
                    ]
                ],
                "expected" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::AUTHOR_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORK_WITH_EMPTY_URL,
                        BundleConstants::SEARCHABLE_FIELD_KEY => true,
                        BundleConstants::SOCIAL_NETWORKS_FIELD_KEY => []
                    ]
                ],
            ],
            [
                "normalizeImage" => false,
                "normalizeSocialNetworks" => true,
                "bannedSocialNetworks" => ["banned_social_network"],
                "entity" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::AUTHOR_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_BANNED_SOCIALNETWORK
                    ]
                ],
                "expected" => [
                    BundleConstants::ID_FIELD_KEY => 1,
                    BundleConstants::AUTHOR_FIELD_KEY => [
                        BundleConstants::ID_FIELD_KEY => TestHelper::AUTHOR_ID_TO_RETURN_WITH_BANNED_SOCIALNETWORK,
                        BundleConstants::SEARCHABLE_FIELD_KEY => true,
                        BundleConstants::SOCIAL_NETWORKS_FIELD_KEY => []
                    ]
                ],
            ],
        ];
    }
}