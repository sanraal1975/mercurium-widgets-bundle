<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Tests\TestCase;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\ArticleAuthorNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
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
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $testHelper = new TestHelper();
        $this->testHelper = $testHelper;
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
     * @dataProvider normalizeReturnsEntity
     * @param $normalizeImage
     * @param $normalizeSocialNetworks
     * @param $bannedSocialNetworks
     * @param $entity
     * @param $expected
     *
     * @return void
     * @throws \Exception
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
                "entity" => ["author" => ["id" => 1]],
                "expected" => ["author" => ["id" => 1, "searchable" => true]],
            ],
            [
                "normalizeImage" => true,
                "normalizeSocialNetworks" => false,
                "bannedSocialNetworks" => [],
                "entity" => ["id" => 1, "author" => ["id" => TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET]],
                "expected" => ["id" => 1, "author" => ["id" => TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET, "searchable" => true, "asset" => ["id" => 1, "searchable" => true]]],
            ],
            [
                "normalizeImage" => true,
                "normalizeSocialNetworks" => true,
                "bannedSocialNetworks" => [],
                "entity" => ["id" => 1, "author" => ["id" => TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET]],
                "expected" => ["id" => 1, "author" => ["id" => TestHelper::AUTHOR_ID_TO_RETURN_WITH_ASSET, "searchable" => true, "asset" => ["id" => 1, "searchable" => true]]],
            ],
            [
                "normalizeImage" => false,
                "normalizeSocialNetworks" => true,
                "bannedSocialNetworks" => [],
                "entity" => ["id" => 1, "author" => ["id" => TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORKS]],
                "expected" => [
                    "id" => 1,
                    "author" => [
                        "id" => TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORKS,
                        "searchable" => true,
                        "socialNetworks" => [
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
                "entity" => ["id" => 1, "author" => ["id" => TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORK_WITH_EMPTY_URL]],
                "expected" => [
                    "id" => 1,
                    "author" => [
                        "id" => TestHelper::AUTHOR_ID_TO_RETURN_WITH_SOCIALNETWORK_WITH_EMPTY_URL,
                        "searchable" => true,
                        "socialNetworks" => []
                    ]
                ],
            ],
            [
                "normalizeImage" => false,
                "normalizeSocialNetworks" => true,
                "bannedSocialNetworks" => ["banned_social_network"],
                "entity" => ["id" => 1, "author" => ["id" => TestHelper::AUTHOR_ID_TO_RETURN_WITH_BANNED_SOCIALNETWORK]],
                "expected" => [
                    "id" => 1,
                    "author" => [
                        "id" => TestHelper::AUTHOR_ID_TO_RETURN_WITH_BANNED_SOCIALNETWORK,
                        "searchable" => true,
                        "socialNetworks" => []
                    ]
                ],
            ],
        ];
    }

}