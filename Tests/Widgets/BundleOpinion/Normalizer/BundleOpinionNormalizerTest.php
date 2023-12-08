<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleOpinion\Normalizer;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers\NormalizerMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\Normalizer\BundleOpinionNormalizer;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

class BundleOpinionNormalizerTest extends TestCase
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

        $helper = new BundleOpinionNormalizer();
    }

    /**
     * @return void
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleOpinionNormalizer(null);
    }

    /**
     * @return void
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new BundleOpinionNormalizer($this->normalizer);
        $result = $normalizer->normalize();
    }

    /**
     * @return void
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new BundleOpinionNormalizer($this->normalizer);
        $result = $normalizer->normalize(null);
    }

    /**
     * @dataProvider normalizeReturnsValue
     *
     * @return void
     */
    public function testNormalizeReturnsValue($entities, $expected)
    {
        $normalizer = new BundleOpinionNormalizer($this->normalizer);

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