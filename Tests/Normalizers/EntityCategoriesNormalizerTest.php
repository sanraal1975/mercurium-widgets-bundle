<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\CategoryHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityCategoriesNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class EntityCategoriesNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers
 */
class EntityCategoriesNormalizerTest extends TestCase
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

        new EntityCategoriesNormalizer();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @param $api
     * @param $field
     * @param $quantity
     *
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException($api, $field, $quantity)
    {
        $this->expectException(TypeError::class);

        new EntityCategoriesNormalizer($api, $field, $quantity);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "api" => null,
                "field" => null,
                "quantity" => null
            ],
            [
                "api" => $this->api,
                "field" => null,
                "quantity" => null
            ],
            [
                "api" => $this->api,
                "field" => "categories",
                "quantity" => null
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageEmptyField()
    {
        $this->expectExceptionMessage(EntityCategoriesNormalizer::EMPTY_FIELD);

        new EntityCategoriesNormalizer($this->api, "");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageQuantityEqualGreaterThanZero()
    {
        $this->expectExceptionMessage(EntityCategoriesNormalizer::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $quantity = $this->testHelper->getZeroOrNegativeValue();

        new EntityCategoriesNormalizer($this->api, "categories", $quantity);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new EntityCategoriesNormalizer($this->api);
        $normalizer->normalize();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new EntityCategoriesNormalizer($this->api);
        $normalizer->normalize(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEmpty()
    {
        $normalizer = new EntityCategoriesNormalizer($this->api);
        $result = $normalizer->normalize([]);

        $this->assertEmpty($result);
    }

    /**
     * @dataProvider normalizeReturnsInputEntity
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsInputEntity($entity, $expected)
    {
        $normalizer = new EntityCategoriesNormalizer($this->api);
        $result = $normalizer->normalize($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function normalizeReturnsInputEntity(): array
    {
        return [
            [
                "entity" => [BundleConstants::ID_FIELD_KEY => 1],
                "expected" => [BundleConstants::ID_FIELD_KEY => 1],
            ],
            [
                "entity" => [BundleConstants::ID_FIELD_KEY => 1, "categories" => null],
                "expected" => [BundleConstants::ID_FIELD_KEY => 1, "categories" => null],
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEntityWithFieldEmptied()
    {
        $normalizer = new EntityCategoriesNormalizer($this->api, "categories", 0);
        $result = $normalizer->normalize([BundleConstants::ID_FIELD_KEY => 1, "categories" => [[BundleConstants::ID_FIELD_KEY => 2]]]);

        $expected = [BundleConstants::ID_FIELD_KEY => 1, "categories" => []];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsExceptionMessageEntityIdMustBeGreaterThanZero()
    {
        $this->expectExceptionMessage(CategoryHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $normalizer = new EntityCategoriesNormalizer($this->api, "categories", 1);
        $categoryId = $this->testHelper->getZeroOrNegativeValue();

        $normalizer->normalize([BundleConstants::ID_FIELD_KEY => 1, "categories" => [[BundleConstants::ID_FIELD_KEY => $categoryId]]]);
    }

    /**
     * @dataProvider normalizeReturnsEntityCategoriesNormalized
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEntityCategoriesNormalized($entity, $expected, $quantity)
    {
        $normalizer = new EntityCategoriesNormalizer($this->api, "categories", $quantity);

        $result = $normalizer->normalize($entity);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function normalizeReturnsEntityCategoriesNormalized(): array
    {
        return [
            [
                "entity" => [BundleConstants::ID_FIELD_KEY => 1, "categories" => [[BundleConstants::ID_FIELD_KEY => 1]]],
                "expected" => [BundleConstants::ID_FIELD_KEY => 1, "categories" => [[BundleConstants::ID_FIELD_KEY => 1, BundleConstants::SEARCHABLE_FIELD_KEY => true]]],
                "quantity" => 1
            ],
            [
                "entity" => [BundleConstants::ID_FIELD_KEY => 1, "categories" => [[BundleConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY]]],
                "expected" => [BundleConstants::ID_FIELD_KEY => 1, "categories" => []],
                "quantity" => 1
            ],
            [
                "entity" => [BundleConstants::ID_FIELD_KEY => 1, "categories" => [[BundleConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY], [BundleConstants::ID_FIELD_KEY => 1]]],
                "expected" => [BundleConstants::ID_FIELD_KEY => 1, "categories" => [[BundleConstants::ID_FIELD_KEY => 1, BundleConstants::SEARCHABLE_FIELD_KEY => true]]],
                "quantity" => 1
            ],
            [
                "entity" => [BundleConstants::ID_FIELD_KEY => 1, "categories" => [[BundleConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY], [BundleConstants::ID_FIELD_KEY => 1], [BundleConstants::ID_FIELD_KEY => 2]]],
                "expected" => [BundleConstants::ID_FIELD_KEY => 1, "categories" => [[BundleConstants::ID_FIELD_KEY => 1, BundleConstants::SEARCHABLE_FIELD_KEY => true]]],
                "quantity" => 1
            ],
            [
                "entity" => [BundleConstants::ID_FIELD_KEY => 1, "categories" => [[BundleConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY], [BundleConstants::ID_FIELD_KEY => 1], [BundleConstants::ID_FIELD_KEY => 2]]],
                "expected" => [BundleConstants::ID_FIELD_KEY => 1, "categories" => [[BundleConstants::ID_FIELD_KEY => 1, BundleConstants::SEARCHABLE_FIELD_KEY => true], [BundleConstants::ID_FIELD_KEY => 2, BundleConstants::SEARCHABLE_FIELD_KEY => true]]],
                "quantity" => 2
            ]
        ];
    }
}