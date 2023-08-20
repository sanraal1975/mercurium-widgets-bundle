<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AuthorHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAuthorNormalizer;
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
     *
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException($api, $field)
    {
        $this->expectException(TypeError::class);

        new EntityAuthorNormalizer($api, $field);
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
     * @dataProvider normalizeReturnEntity
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnEntity(array $entity)
    {
        $normalizer = new EntityAuthorNormalizer($this->api);
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
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => [BundleConstants::ID_FIELD_KEY => "a"]]
            ],
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => [BundleConstants::ID_FIELD_KEY => null]]
            ],
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => [BundleConstants::ID_FIELD_KEY => []]]
            ],
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => BundleConstants::ID_FIELD_KEY]
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

        $entity = ["author" => [BundleConstants::ID_FIELD_KEY => $this->testHelper->getZeroOrNegativeValue()]];

        $normalizer = new EntityAuthorNormalizer($this->api);
        $normalizer->normalize($entity);
    }

    /**
     * @dataProvider normalizeReturnsEntityAuthorNormalized
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEntityAuthorNormalized($entity, $expected)
    {
        $normalizer = new EntityAuthorNormalizer($this->api);

        $result = $normalizer->normalize($entity);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function normalizeReturnsEntityAuthorNormalized(): array
    {
        return [
            [
                "entity" => [BundleConstants::ID_FIELD_KEY => 1, "author" => [BundleConstants::ID_FIELD_KEY => 1]],
                "expected" => [BundleConstants::ID_FIELD_KEY => 1, "author" => [BundleConstants::ID_FIELD_KEY => 1, BundleConstants::SEARCHABLE_FIELD_KEY => true]],
            ],
            [
                "entity" => [BundleConstants::ID_FIELD_KEY => 1, "author" => [BundleConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY]],
                "expected" => [BundleConstants::ID_FIELD_KEY => 1, "author" => []],
            ],
        ];
    }
}