<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AssetHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityImageNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class EntityImageNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers
 */
class EntityImageNormalizerTest extends TestCase
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

        new EntityImageNormalizer();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @param $api
     * @param $field
     *
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException($api, $field)
    {
        $this->expectException(TypeError::class);

        new EntityImageNormalizer($api, $field);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "api" => null,
                "field" => null
            ],
            [
                "api" => $this->api,
                "field" => null
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageEmptyField()
    {
        $this->expectExceptionMessage(EntityImageNormalizer::EMPTY_FIELD);

        new EntityImageNormalizer($this->api, "");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new EntityImageNormalizer($this->api, EntityConstants::IMAGE_FIELD_KEY);
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

        $normalizer = new EntityImageNormalizer($this->api, EntityConstants::IMAGE_FIELD_KEY);
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
     * @dataProvider normalizeReturnEntity
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnEntity(array $entity)
    {
        $normalizer = new EntityImageNormalizer($this->api, EntityConstants::IMAGE_FIELD_KEY);
        $result = $normalizer->normalize($entity);

        $this->assertEquals($entity, $result);
    }

    /**
     * @return array[]
     */
    public function normalizeReturnEntity(): array
    {
        return [
            [
                "entity" => [],
            ],
            [
                "entity" => [EntityConstants::IMAGE_FIELD_KEY => []],
            ],
            [
                "entity" => [EntityConstants::IMAGE_FIELD_KEY => 0],
            ],
            [
                "entity" => [EntityConstants::IMAGE_FIELD_KEY => null],
            ],
            [
                "entity" => [TestHelper::VIDEO_FIELD_KEY => []],
            ]
        ];
    }

    /**
     * @dataProvider normalizeThrowsExceptionMessageNonNumericAssetId
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsExceptionMessageNonNumericAssetId($entity)
    {
        $this->expectExceptionMessage(EntityImageNormalizer::NON_NUMERIC_ASSET_ID);

        $normalizer = new EntityImageNormalizer($this->api, EntityConstants::IMAGE_FIELD_KEY);
        $normalizer->normalize($entity);
    }

    /**
     * @return array[]
     */
    public function normalizeThrowsExceptionMessageNonNumericAssetId(): array
    {
        return [
            [
                "entity" => [EntityConstants::IMAGE_FIELD_KEY => [EntityConstants::ID_FIELD_KEY => "a"]]
            ],
            [
                "entity" => [EntityConstants::IMAGE_FIELD_KEY => [EntityConstants::ID_FIELD_KEY => null]]
            ],
            [
                "entity" => [EntityConstants::IMAGE_FIELD_KEY => [EntityConstants::ID_FIELD_KEY => []]]
            ],
            [
                "entity" => [EntityConstants::IMAGE_FIELD_KEY => EntityConstants::ID_FIELD_KEY]
            ],
            [
                "entity" => [EntityConstants::IMAGE_FIELD_KEY => ["title"]]
            ],
        ];
    }

    /**
     * @dataProvider normalizeReturnsEntityAssetNormalized
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEntityAssetNormalized($entity, $expected)
    {
        $normalizer = new EntityImageNormalizer($this->api, EntityConstants::IMAGE_FIELD_KEY);

        $result = $normalizer->normalize($entity);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function normalizeReturnsEntityAssetNormalized(): array
    {
        return [
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
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true,
                        EntityConstants::ORIENTATION_FIELD_KEY => EntityConstants::IMAGE_ORIENTATION_SQUARE
                    ]
                ],
            ],
            [
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::IMAGE_FIELD_KEY => [
                        EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::IMAGE_FIELD_KEY => []
                ],
            ],
        ];
    }
}