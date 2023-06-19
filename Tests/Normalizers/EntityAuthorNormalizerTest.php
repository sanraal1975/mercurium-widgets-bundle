<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AuthorHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAuthorNormalizer;
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
     * @return void
     * @throws Exception
     */
    public function testConstructWrongTypeParametersWrongApiClient()
    {
        $this->expectException(TypeError::class);

        $normalizer = new EntityAuthorNormalizer(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructWrongTypeParametersWrongField()
    {
        $this->expectException(TypeError::class);

        $api = new Client("https://foo.bar", "fake_token");
        $normalizer = new EntityAuthorNormalizer($api, null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructEmptyField()
    {
        $this->expectExceptionMessage(EntityAuthorNormalizer::EMPTY_FIELD);

        $api = new Client("https://foo.bar", "fake_token");
        $normalizer = new EntityAuthorNormalizer($api, "");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeWrongTypeParametersWrongEntity()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $normalizer = new EntityAuthorNormalizer($api);
        $normalizer->normalize(null);
    }

    /**
     * @dataProvider normalizeReturnEntity
     *
     * @return void
     * @throws Exception
     */
    public function testNormalizeReturnEntity(array $entity)
    {
        $api = new Client("https://foo.bar", "fake_token");

        $normalizer = new EntityAuthorNormalizer($api);
        $result = $normalizer->normalize($entity);

        $this->assertEquals($entity, $result);
    }

    /**
     * @return array[]
     */
    public function normalizeReturnEntity(): array
    {
        /*
         * 0 -> empty entity
         * 1 -> entity with field with empty array as value
         * 2 -> entity with field with 0 as value
         * 3 -> entity with field with null as value
         */

        return [
            [
                "entity" => [],
            ],
            [
                "entity" => ["author" => []],
            ],
            [
                "entity" => ["author" => 0],
            ],
            [
                "entity" => ["author" => null],
            ]
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeNonNumericAuthorIdWrongKeyIdValueIsString()
    {
        $this->expectExceptionMessage(EntityAuthorNormalizer::NON_NUMERIC_AUTHOR_ID);

        $api = new Client("https://foo.bar", "fake_token");
        $entity = ["author" => ["id" => "a"]];

        $normalizer = new EntityAuthorNormalizer($api);
        $normalizer->normalize($entity);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeNonNumericAuthorIdWrongKeyIdValueIsNull()
    {
        $this->expectExceptionMessage(EntityAuthorNormalizer::NON_NUMERIC_AUTHOR_ID);

        $api = new Client("https://foo.bar", "fake_token");
        $entity = ["author" => ["id" => null]];

        $normalizer = new EntityAuthorNormalizer($api);
        $normalizer->normalize($entity);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeNonNumericAuthorIdWrongKeyIdValueIsEmptyArray()
    {
        $this->expectExceptionMessage(EntityAuthorNormalizer::NON_NUMERIC_AUTHOR_ID);

        $api = new Client("https://foo.bar", "fake_token");
        $entity = ["author" => ["id" => []]];

        $normalizer = new EntityAuthorNormalizer($api);
        $normalizer->normalize($entity);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeNonNumericAuthorIdFieldValueIsString()
    {
        $this->expectExceptionMessage(EntityAuthorNormalizer::NON_NUMERIC_AUTHOR_ID);

        $api = new Client("https://foo.bar", "fake_token");
        $entity = ["author" => "id"];

        $normalizer = new EntityAuthorNormalizer($api);
        $normalizer->normalize($entity);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeNonNumericAuthorIdFieldValueIsArrayWithoutIdKey()
    {
        $this->expectExceptionMessage(EntityAuthorNormalizer::NON_NUMERIC_AUTHOR_ID);

        $api = new Client("https://foo.bar", "fake_token");
        $entity = ["author" => ["title"]];

        $normalizer = new EntityAuthorNormalizer($api);
        $normalizer->normalize($entity);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeAuthorFieldIdValueIsZeroOrNegative()
    {
        $this->expectExceptionMessage(AuthorHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $api = new Client("https://foo.bar", "fake_token");

        $id = rand(PHP_INT_MIN, 0);

        $entity = ["author" => ["id" => $id]];

        $normalizer = new EntityAuthorNormalizer($api);
        $normalizer->normalize($entity);
    }
}