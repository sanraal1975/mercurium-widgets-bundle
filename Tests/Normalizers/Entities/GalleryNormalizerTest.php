<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\GalleryNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityCategoriesNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class GalleryNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers\Entities
 */
class GalleryNormalizerTest extends TestCase
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
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        new GalleryNormalizer();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @param $api
     * @param $galleryNormalizer
     * @param $imageNormalizer
     * @param $quantityOfAssetsToNormalize
     *
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException($api, $galleryNormalizer, $imageNormalizer, $quantityOfAssetsToNormalize)
    {
        $this->expectException(TypeError::class);

        new GalleryNormalizer($api, $galleryNormalizer, $imageNormalizer, $quantityOfAssetsToNormalize);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "api" => null,
                "galleryNormalizer" => "",
                "imageNormalizer" => "",
                "quantityOfAssetsToNormalize" => null,
            ],
            [
                "api" => $this->api,
                "galleryNormalizer" => "",
                "imageNormalizer" => "",
                "quantityOfAssetsToNormalize" => null,
            ],
            [
                "api" => $this->api,
                "galleryNormalizer" => null,
                "imageNormalizer" => "",
                "quantityOfAssetsToNormalize" => null,
            ],
            [
                "api" => $this->api,
                "galleryNormalizer" => null,
                "imageNormalizer" => null,
                "quantityOfAssetsToNormalize" => null,
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageEmptyField()
    {
        $this->expectExceptionMessage(GalleryNormalizer::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        new GalleryNormalizer($this->api, null, null, $this->testHelper->getNegativeValue());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new GalleryNormalizer(
            $this->api
        );

        $entity = $normalizer->normalize();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @param $api
     * @param $galleryNormalizer
     * @param $imageNormalizer
     * @param $quantityOfAssetsToNormalize
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException($api, $galleryNormalizer, $imageNormalizer, $quantityOfAssetsToNormalize)
    {
        $this->expectException(TypeError::class);

        $normalizer = new GalleryNormalizer(
            $this->api
        );

        $entity = null;
        $entity = $normalizer->normalize($entity);
    }

    /**
     * @dataProvider normalize
     *
     * @param $entity
     * @param $expected
     * @param $galleryNormalizer
     * @param $assetNormalizer
     * @param $assetsQuantity
     *
     * @return void
     * @throws Exception
     */
    public function testNormalize($entity, $expected, $galleryNormalizer, $assetNormalizer, $assetsQuantity)
    {
        $normalizer = new GalleryNormalizer(
            $this->api,
            $galleryNormalizer,
            $assetNormalizer,
            $assetsQuantity
        );

        $result = $normalizer->normalize($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function normalize(): array
    {
        return [
            [
                "entity" => [],
                "expected" => [],
                "galleryNormalizer" => null,
                "assetNormalizer" => null,
                "assetsQuantity" => 0
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::TOTAL_ASSETS_FIELD_KEY => 0
                ],
                "galleryNormalizer" => null,
                "assetNormalizer" => null,
                "assetsQuantity" => 0
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::TOTAL_ASSETS_FIELD_KEY => 0
                ],
                "galleryNormalizer" => new EntityNormalizer(
                    [
                        new EntityCategoriesNormalizer($this->api)
                    ]
                ),
                "assetNormalizer" => null,
                "assetsQuantity" => 0
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::ASSETS_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1
                        ]
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::ASSETS_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1
                        ]
                    ],
                    EntityConstants::TOTAL_ASSETS_FIELD_KEY => 1
                ],
                "galleryNormalizer" => null,
                "assetNormalizer" => null,
                "assetsQuantity" => 0
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::ASSETS_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1
                        ]
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::ASSETS_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::SEARCHABLE_FIELD_KEY => true,
                            "orientation" => "is-horizontal",
                        ]
                    ],
                    EntityConstants::TOTAL_ASSETS_FIELD_KEY => 1
                ],
                "galleryNormalizer" => null,
                "assetNormalizer" => null,
                "assetsQuantity" => 1
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::ASSETS_FIELD_KEY => [[]]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::ASSETS_FIELD_KEY => [],
                    EntityConstants::TOTAL_ASSETS_FIELD_KEY => 1
                ],
                "galleryNormalizer" => null,
                "assetNormalizer" => null,
                "assetsQuantity" => 1
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::ASSETS_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY
                        ]
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::ASSETS_FIELD_KEY => [],
                    EntityConstants::TOTAL_ASSETS_FIELD_KEY => 1
                ],
                "galleryNormalizer" => null,
                "assetNormalizer" => null,
                "assetsQuantity" => 1
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::ASSETS_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1
                        ]
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::ASSETS_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::SEARCHABLE_FIELD_KEY => true,
                            "orientation" => "is-horizontal",
                        ]
                    ],
                    EntityConstants::TOTAL_ASSETS_FIELD_KEY => 1
                ],
                "galleryNormalizer" => null,
                "assetNormalizer" => new EntityNormalizer(
                    [
                        new EntityCategoriesNormalizer($this->api)
                    ]
                ),
                "assetsQuantity" => 1
            ],
        ];
    }
}