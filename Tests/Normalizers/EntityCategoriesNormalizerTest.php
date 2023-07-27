<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\CategoryHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityCategoriesNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\CategoryHelperMock;
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
     * @param $helper
     * @param $field
     * @param $quantity
     *
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException($helper, $field, $quantity)
    {
        $this->expectException(TypeError::class);

        new EntityCategoriesNormalizer($helper, $field, $quantity);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "helper" => null,
                "field" => null,
                "quantity" => null
            ],
            [
                "helper" => new CategoryHelper($this->testHelper->getApi()),
                "field" => null,
                "quantity" => null
            ],
            [
                "helper" => new CategoryHelper($this->testHelper->getApi()),
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

        $helper = new CategoryHelper($this->testHelper->getApi());

        new EntityCategoriesNormalizer($helper, "");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageQuantityEqualGreaterThanZero()
    {
        $this->expectExceptionMessage(EntityCategoriesNormalizer::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new CategoryHelper($this->testHelper->getApi());
        $quantity = $this->testHelper->getZeroOrNegativeValue();

        new EntityCategoriesNormalizer($helper, "categories", $quantity);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new CategoryHelper($this->testHelper->getApi());
        $normalizer = new EntityCategoriesNormalizer($helper);
        $normalizer->normalize();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new CategoryHelper($this->testHelper->getApi());
        $normalizer = new EntityCategoriesNormalizer($helper);
        $normalizer->normalize(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEmpty()
    {
        $helper = new CategoryHelper($this->testHelper->getApi());
        $normalizer = new EntityCategoriesNormalizer($helper);
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
        $helper = new CategoryHelper($this->testHelper->getApi());
        $normalizer = new EntityCategoriesNormalizer($helper);
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
                "entity" => ["id" => 1],
                "expected" => ["id" => 1],
            ],
            [
                "entity" => ["id" => 1, "categories" => null],
                "expected" => ["id" => 1, "categories" => null],
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEntityWithFieldEmptied()
    {
        $helper = new CategoryHelper($this->testHelper->getApi());
        $normalizer = new EntityCategoriesNormalizer($helper, "categories", 0);
        $result = $normalizer->normalize(["id" => 1, "categories" => [["id" => 2]]]);

        $expected = ["id" => 1, "categories" => []];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsExceptionMessageEntityIdMustBeGreaterThanZero()
    {
        $this->expectExceptionMessage(CategoryHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new CategoryHelper($this->testHelper->getApi());
        $normalizer = new EntityCategoriesNormalizer($helper, "categories", 1);
        $categoryId = $this->testHelper->getZeroOrNegativeValue();

        $normalizer->normalize(["id" => 1, "categories" => [["id" => $categoryId]]]);
    }

    /**
     * @dataProvider normalizeReturnsEntityCategoriesNormalized
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEntityCategoriesNormalized($entity, $expected, $quantity)
    {
        $helper = new CategoryHelperMock($this->testHelper->getApi());
        $normalizer = new EntityCategoriesNormalizer($helper, "categories", $quantity);

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
                "entity" => ["id" => 1, "categories" => [["id" => 1]]],
                "expected" => ["id" => 1, "categories" => [["id" => 1]]],
                "quantity" => 1
            ],
            [
                "entity" => ["id" => 1, "categories" => [["id" => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY]]],
                "expected" => ["id" => 1, "categories" => []],
                "quantity" => 1
            ],
            [
                "entity" => ["id" => 1, "categories" => [["id"=>$this->testHelper::ENTITY_ID_TO_RETURN_EMPTY],["id" => 1]]],
                "expected" => ["id" => 1, "categories" => [["id" => 1]]],
                "quantity" => 1
            ],
            [
                "entity" => ["id" => 1, "categories" => [["id"=>$this->testHelper::ENTITY_ID_TO_RETURN_EMPTY],["id" => 1],["id" => 2]]],
                "expected" => ["id" => 1, "categories" => [["id" => 1]]],
                "quantity" => 1
            ],
            [
                "entity" => ["id" => 1, "categories" => [["id"=>$this->testHelper::ENTITY_ID_TO_RETURN_EMPTY],["id" => 1],["id" => 2]]],
                "expected" => ["id" => 1, "categories" => [["id" => 1],["id" => 2]]],
                "quantity" => 2
            ]
        ];
    }
}