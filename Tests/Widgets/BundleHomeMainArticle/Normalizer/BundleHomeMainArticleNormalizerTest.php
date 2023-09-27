<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHomeMainArticle\Normalizer;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers\NormalizerMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Normalizer\BundleHomeMainArticleNormalizer;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\ValueObject\BundleHomeMainArticleValueObject;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class BundleHomeMainArticleNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHomeMainArticle\Normalizer
 */
class BundleHomeMainArticleNormalizerTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @var EntityNormalizer
     */
    private $normalizer;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     * @throws Exception
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $testHelper = new TestHelper();
        $this->testHelper = $testHelper;
        $this->normalizer = new EntityNormalizer([new NormalizerMock()]);
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new BundleHomeMainArticleNormalizer();
    }

    /**
     * @return void
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleHomeMainArticleNormalizer(null);
    }

    /**
     * @return void
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new BundleHomeMainArticleNormalizer($this->normalizer);
        $result = $normalizer->normalize();
    }

    /**
     * @return void
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new BundleHomeMainArticleNormalizer($this->normalizer);
        $result = $normalizer->normalize(null);
    }

    /**
     * @dataProvider normalizeReturnsValue
     *
     * @return void
     */
    public function testNormalizeReturnsValue($entities, $expected)
    {
        $normalizer = new BundleHomeMainArticleNormalizer($this->normalizer);

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
                "entities" => [0 => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::SEARCHABLE_FIELD_KEY => true]],
                "expected" => [0 => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::SEARCHABLE_FIELD_KEY => true]],
            ],
            [
                "entities" => [0 => [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::SEARCHABLE_FIELD_KEY => false]],
                "expected" => [],
            ],
            [
                "entities" => [0 => [EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY, EntityConstants::SEARCHABLE_FIELD_KEY => true]],
                "expected" => [],
            ],
        ];
    }
}