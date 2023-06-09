<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AssetHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAssetNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class EntityAssetNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers
 */
class EntityAssetNormalizerTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->testHelper = new TestHelper();
    }

    /**
     * @dataProvider constructThrowsArgumentCountErrorException
     *
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        new EntityAssetNormalizer();
    }

    /**
     * @return array
     */
    public function constructThrowsArgumentCountErrorException(): array
    {
        return [
            [
                "api" => null,
                "field" => null
            ],
            [
                "api" => $this->testHelper->getApi(),
                "field" => null
            ],
        ];
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

        $helper = new EntityAssetNormalizer($api, $field);
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
                "api" => $this->testHelper->getApi(),
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
        $this->expectExceptionMessage(EntityAssetNormalizer::EMPTY_FIELD);

        new EntityAssetNormalizer($this->testHelper->getApi(), "");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new EntityAssetNormalizer($this->testHelper->getApi(), TestHelper::IMAGE_FIELD_KEY);
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

        $normalizer = new EntityAssetNormalizer($this->testHelper->getApi(), TestHelper::IMAGE_FIELD_KEY);

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
        $normalizer = new EntityAssetNormalizer($this->testHelper->getApi(), TestHelper::IMAGE_FIELD_KEY);
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
                "entity" => [TestHelper::IMAGE_FIELD_KEY => []],
            ],
            [
                "entity" => [TestHelper::IMAGE_FIELD_KEY => 0],
            ],
            [
                "entity" => [TestHelper::IMAGE_FIELD_KEY => null],
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
        $this->expectExceptionMessage(EntityAssetNormalizer::NON_NUMERIC_ASSET_ID);

        $normalizer = new EntityAssetNormalizer($this->testHelper->getApi(), TestHelper::IMAGE_FIELD_KEY);
        $normalizer->normalize($entity);
    }

    /**
     * @return array[]
     */
    public function normalizeThrowsExceptionMessageNonNumericAssetId(): array
    {
        return [
            [
                "entity" => [TestHelper::IMAGE_FIELD_KEY => ["id" => "a"]]
            ],
            [
                "entity" => [TestHelper::IMAGE_FIELD_KEY => ["id" => null]]
            ],
            [
                "entity" => [TestHelper::IMAGE_FIELD_KEY => ["id" => []]]
            ],
            [
                "entity" => [TestHelper::IMAGE_FIELD_KEY => "id"]
            ],
            [
                "entity" => [TestHelper::IMAGE_FIELD_KEY => ["title"]]
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeAuthorThrowsExceptionMessageNonNumericAssetId()
    {
        $this->expectExceptionMessage(AssetHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $entity = [TestHelper::IMAGE_FIELD_KEY => ["id" => $this->testHelper->getZeroOrNegativeValue()]];

        $normalizer = new EntityAssetNormalizer($this->testHelper->getApi(), TestHelper::IMAGE_FIELD_KEY);
        $normalizer->normalize($entity);
    }
}