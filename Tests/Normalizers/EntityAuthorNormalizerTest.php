<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Normalizers;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AuthorApiService;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AuthorHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAuthorNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Helpers\AuthorHelperMock;
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
     * @var AuthorApiService
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
        $this->service = $factory->createAuthorApiService();

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
    public function testConstructThrowsTypeErrorException($helper, $field)
    {
        $this->expectException(TypeError::class);

        $helper = new EntityAuthorNormalizer($helper, $field);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "helper" => null,
                "field" => null
            ],
            [
                "helper" => new AuthorHelper($this->service),
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

        $helper = new AuthorHelper($this->service);
        new EntityAuthorNormalizer($helper, "");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new AuthorHelper($this->service);
        $normalizer = new EntityAuthorNormalizer($helper);
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

        $helper = new AuthorHelper($this->service);
        $normalizer = new EntityAuthorNormalizer($helper);

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

        $helper = new AuthorHelper($this->service);
        $normalizer = new EntityAuthorNormalizer($helper);
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

        $helper = new AuthorHelper($this->service);
        $normalizer = new EntityAuthorNormalizer($helper);
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

        $helper = new AuthorHelper($this->service);
        $normalizer = new EntityAuthorNormalizer($helper);
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
        $helper = new AuthorHelperMock($this->service);
        $normalizer = new EntityAuthorNormalizer($helper);

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
                "entity" => ["id" => 1, "author" => ["id" => 1]],
                "expected" => ["id" => 1, "author" => ["id" => 1, "searchable" => true]],
            ],
            [
                "entity" => ["id" => 1, "author" => ["id" => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY]],
                "expected" => ["id" => 1, "author" => []],
            ],
        ];
    }
}