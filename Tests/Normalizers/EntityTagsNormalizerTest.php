<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Services\TagApiService;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\TagHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityTagsNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
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

        $factory = new ApiServiceFactory($this->testHelper->getApi());
        $this->service = $factory->createTagApiService();

        $this->api = $this->testHelper->getApi();
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

        new EntityTagsNormalizer($this->api, $field, $quantity);
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
                "helper" => new TagHelper($this->api),
                "field" => null,
                "quantity" => null
            ],
            [
                "helper" => new TagHelper($this->api),
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

        new EntityTagsNormalizer($this->api, "");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageQuantityEqualGreaterThanZero()
    {
        $this->expectExceptionMessage(EntityTagsNormalizer::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);

        $quantity = $this->testHelper->getZeroOrNegativeValue();

        new EntityTagsNormalizer($this->api, "tags", $quantity);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new EntityTagsNormalizer($this->api);
        $normalizer->normalize();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new EntityTagsNormalizer($this->api);
        $normalizer->normalize(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEmpty()
    {
        $normalizer = new EntityTagsNormalizer($this->api);
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
        $normalizer = new EntityTagsNormalizer($this->api);
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
        $normalizer = new EntityTagsNormalizer($this->api, "tags", 0);
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

        $normalizer = new EntityTagsNormalizer($this->api, "tags", 1);
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
        $normalizer = new EntityTagsNormalizer($this->api, "tags", $quantity);

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