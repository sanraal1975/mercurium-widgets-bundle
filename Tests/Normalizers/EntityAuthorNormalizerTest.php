<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AuthorHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAuthorNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
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

        $helper = new EntityAuthorNormalizer($api, $field);
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
    public function testValidateEmptyField()
    {
        $this->expectExceptionMessage(EntityAuthorNormalizer::EMPTY_FIELD);

        new EntityAuthorNormalizer($this->testHelper->getApi(), "");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new EntityAuthorNormalizer($this->testHelper->getApi());
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

        $normalizer = new EntityAuthorNormalizer($this->testHelper->getApi());

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

        $normalizer = new EntityAuthorNormalizer($this->testHelper->getApi());
        $normalizer->normalize($entity);
    }

    /**
     * @return array[]
     */
    public function normalizeThrowsExceptionMessageNonNumericAuthorId(): array
    {
        return [
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => ["id" => "a"]]
            ],
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => ["id" => null]]
            ],
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => ["id" => []]]
            ],
            [
                "entity" => [TestHelper::AUTHOR_FIELD_KEY => "id"]
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

        $entity = ["author" => ["id" => $this->testHelper->getZeroOrNegativeValue()]];

        $normalizer = new EntityAuthorNormalizer($this->testHelper->getApi());
        $normalizer->normalize($entity);
    }
}