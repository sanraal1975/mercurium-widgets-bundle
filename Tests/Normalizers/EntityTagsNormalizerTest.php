<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
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
                "field" => EntityConstants::TAGS_FIELD_KEY,
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

        new EntityTagsNormalizer($this->api, EntityConstants::TAGS_FIELD_KEY, $quantity);
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
                "entity" => [EntityConstants::ID_FIELD_KEY => 1],
                "expected" => [EntityConstants::ID_FIELD_KEY => 1],
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => null],
                "expected" => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => null],
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEntityWithFieldEmptied()
    {
        $normalizer = new EntityTagsNormalizer($this->api, EntityConstants::TAGS_FIELD_KEY, 0);
        $result = $normalizer->normalize([EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => 2]]]);

        $expected = [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => []];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsExceptionMessageEntityIdMustBeGreaterThanZero()
    {
        $this->expectExceptionMessage(TagHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $normalizer = new EntityTagsNormalizer($this->api, EntityConstants::TAGS_FIELD_KEY, 1);
        $categoryId = $this->testHelper->getZeroOrNegativeValue();

        $normalizer->normalize([EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => $categoryId]]]);
    }

    /**
     * @dataProvider normalizeReturnsEntityTagsNormalized
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnsEntityTagsNormalized($entity, $expected, $quantity)
    {
        $normalizer = new EntityTagsNormalizer($this->api, EntityConstants::TAGS_FIELD_KEY, $quantity);

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
                "entity" => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => 1]]],
                "expected" => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => 1, EntityConstants::SEARCHABLE_FIELD_KEY => true]]],
                "quantity" => 1
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY]]],
                "expected" => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => []],
                "quantity" => 1
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY], [EntityConstants::ID_FIELD_KEY => 1]]],
                "expected" => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => 1, EntityConstants::SEARCHABLE_FIELD_KEY => true]]],
                "quantity" => 1
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY], [EntityConstants::ID_FIELD_KEY => 1], [EntityConstants::ID_FIELD_KEY => 2]]],
                "expected" => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => 1, EntityConstants::SEARCHABLE_FIELD_KEY => true]]],
                "quantity" => 1
            ],
            [
                "entity" => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY], [EntityConstants::ID_FIELD_KEY => 1], [EntityConstants::ID_FIELD_KEY => 2]]],
                "expected" => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::TAGS_FIELD_KEY => [[EntityConstants::ID_FIELD_KEY => 1, EntityConstants::SEARCHABLE_FIELD_KEY => true], [EntityConstants::ID_FIELD_KEY => 2, EntityConstants::SEARCHABLE_FIELD_KEY => true]]],
                "quantity" => 2
            ]
        ];
    }
}