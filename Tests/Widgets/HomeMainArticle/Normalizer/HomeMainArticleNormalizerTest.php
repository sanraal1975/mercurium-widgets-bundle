<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\HomeMainArticle\Normalizer;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers\NormalizerMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\HomeMainArticle\Normalizer\HomeMainArticleNormalizer;
use Comitium5\MercuriumWidgetsBundle\Widgets\HomeMainArticle\ValueObject\HomeMainArticleValueObject;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class HomeMainArticleNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\HomeMainArticle\Normalizer
 */
class HomeMainArticleNormalizerTest extends TestCase
{
    /**
     * @var ClientMock
     */
    private $api;

    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @var HomeMainArticleValueObject
     */
    private $valueObject;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     * @throws \Exception
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $testHelper = new TestHelper();
        $this->testHelper = $testHelper;
        $this->api = $testHelper->getApi();
        $this->valueObject = new HomeMainArticleValueObject(
            $testHelper->getApi(),
            "1",
            new EntityNormalizer(
                [
                    new NormalizerMock()
                ]
            )
        );
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new HomeMainArticleNormalizer();
    }

    /**
     * @return void
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new HomeMainArticleNormalizer(null);
    }

    /**
     * @return void
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new HomeMainArticleNormalizer($this->valueObject);
        $result = $normalizer->normalize();
    }

    /**
     * @return void
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new HomeMainArticleNormalizer($this->valueObject);
        $result = $normalizer->normalize(null);
    }

    /**
     * @dataProvider normalizeReturnsValue
     *
     * @return void
     */
    public function testNormalizeReturnsValue($entities, $expected)
    {
        $normalizer = new HomeMainArticleNormalizer($this->valueObject);

        $result = $normalizer->normalize($entities);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function normalizeReturnsValue(): array
    {
        return [
            [
                "entities" => [],
                "expected" => []
            ],
            [
                "entities" => [0 => []],
                "expected" => []
            ],
            [
                "entities" => [0 => ["id" => 1, "searchable" => true]],
                "expected" => [0 => ["id" => 1, "searchable" => true]],
            ],
            [
                "entities" => [0 => ["id" => 1, "searchable" => false]],
                "expected" => [],
            ],
            [
                "entities" => [0 => ["id" => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY, "searchable" => true]],
                "expected" => [],
            ],
        ];
    }
}