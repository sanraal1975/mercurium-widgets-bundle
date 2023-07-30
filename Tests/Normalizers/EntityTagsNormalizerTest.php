<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Services\TagApiService;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\TagHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityTagsNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Helpers\TagHelperMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class EntityTagsNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Normalizers
 */
class EntityTagsNormalizerTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @var TagApiService
     */
    private $service;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->testHelper = new TestHelper();

        $factory = new ApiServiceFactory($this->testHelper->getApi());
        $this->service = $factory->createTagApiService();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        new EntityTagsNormalizer();
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

        new EntityTagsNormalizer($helper, $field, $quantity);
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
                "helper" => new TagHelper($this->service),
                "field" => null,
                "quantity" => null
            ],
            [
                "helper" => new TagHelper($this->service),
                "field" => "tags",
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
        $this->expectExceptionMessage(EntityTagsNormalizer::EMPTY_FIELD);

        $helper = new TagHelper($this->service);

        new EntityTagsNormalizer($helper, "");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageQuantityEqualGreaterThanZero()
    {
        $this->expectExceptionMessage(EntityTagsNormalizer::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $helper = new TagHelper($this->service);
        $quantity = $this->testHelper->getZeroOrNegativeValue();

        new EntityTagsNormalizer($helper, "tags", $quantity);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new TagHelper($this->service);
        $normalizer = new EntityTagsNormalizer($helper);
        $normalizer->normalize();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new TagHelper($this->service);
        $normalizer = new EntityTagsNormalizer($helper);
        $normalizer->normalize(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEmpty()
    {
        $helper = new TagHelper($this->service);
        $normalizer = new EntityTagsNormalizer($helper);
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
        $helper = new TagHelper($this->service);
        $normalizer = new EntityTagsNormalizer($helper);
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
                "entity" => ["id" => 1, "tags" => null],
                "expected" => ["id" => 1, "tags" => null],
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEntityWithFieldEmptied()
    {
        $helper = new TagHelper($this->service);
        $normalizer = new EntityTagsNormalizer($helper, "tags", 0);
        $result = $normalizer->normalize(["id" => 1, "tags" => [["id" => 2]]]);

        $expected = ["id" => 1, "tags" => []];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsExceptionMessageEntityIdMustBeGreaterThanZero()
    {
        $this->expectExceptionMessage(TagHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new TagHelper($this->service);
        $normalizer = new EntityTagsNormalizer($helper, "tags", 1);
        $categoryId = $this->testHelper->getZeroOrNegativeValue();

        $normalizer->normalize(["id" => 1, "tags" => [["id" => $categoryId]]]);
    }

    /**
     * @dataProvider normalizeReturnsEntityTagsNormalized
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEntityTagsNormalized($entity, $expected, $quantity)
    {
        $helper = new TagHelperMock($this->service);
        $normalizer = new EntityTagsNormalizer($helper, "tags", $quantity);

        $result = $normalizer->normalize($entity);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function normalizeReturnsEntityTagsNormalized(): array
    {
        return [
            [
                "entity" => ["id" => 1, "tags" => [["id" => 1]]],
                "expected" => ["id" => 1, "tags" => [["id" => 1, "searchable" => true]]],
                "quantity" => 1
            ],
            [
                "entity" => ["id" => 1, "tags" => [["id" => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY]]],
                "expected" => ["id" => 1, "tags" => []],
                "quantity" => 1
            ],
            [
                "entity" => ["id" => 1, "tags" => [["id" => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY], ["id" => 1]]],
                "expected" => ["id" => 1, "tags" => [["id" => 1, "searchable" => true]]],
                "quantity" => 1
            ],
            [
                "entity" => ["id" => 1, "tags" => [["id" => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY], ["id" => 1], ["id" => 2]]],
                "expected" => ["id" => 1, "tags" => [["id" => 1, "searchable" => true]]],
                "quantity" => 1
            ],
            [
                "entity" => ["id" => 1, "tags" => [["id" => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY], ["id" => 1], ["id" => 2]]],
                "expected" => ["id" => 1, "tags" => [["id" => 1, "searchable" => true], ["id" => 2, "searchable" => true]]],
                "quantity" => 2
            ]
        ];
    }
}