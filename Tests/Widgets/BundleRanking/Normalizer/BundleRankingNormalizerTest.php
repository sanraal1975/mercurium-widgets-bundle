<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleRanking\Normalizer;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers\NormalizerMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleRanking\ValueObject\BundleRankingValueObjectMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Normalizer\BundleRankingNormalizer;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class BundleRankingNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleRanking\Normalizer
 */
class BundleRankingNormalizerTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @var BundleRankingValueObjectMock
     */
    private $valueObject;

    /**
     * @var false|string
     */
    private $cwd;

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

        $cwd = getcwd();
        $fileExists = $cwd . "/Tests/Widgets/BundleRanking/Helper/BundleRankingJson.json";

        $this->valueObject = new BundleRankingValueObjectMock(
            $this->testHelper->getApi(),
            BundleConstants::LOCALE_ES,
            "foo.bar",
            $this->testHelper->getPositiveValue(),
            BundleConstants::ENVIRONMENT_DEV,
            $fileExists,
            $fileExists,
            "https://www.foo.bar",
            "foo",
            "bar"
        );

        $this->normalizer = new EntityNormalizer(
            [
                new NormalizerMock()
            ]
        );

        $this->cwd = getcwd();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new BundleRankingNormalizer();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new BundleRankingNormalizer(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new BundleRankingNormalizer($this->normalizer);
        $results = $normalizer->normalize();

    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new BundleRankingNormalizer($this->normalizer);
        $results = $normalizer->normalize(null);
    }

    /**
     * @dataProvider normalize
     *
     * @return void
     * @throws Exception
     */
    public function testNormalize($content, $expected)
    {
        $normalizer = new BundleRankingNormalizer($this->normalizer);
        $result = $normalizer->normalize($content);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function normalize(): array
    {
        return [
            [
                "content" => [],
                "expected" => []
            ],
            [
                "content" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1
                    ]
                ],
                "expected" => []
            ],
            [
                "content" => [
                    [
                        EntityConstants::ID_FIELD_KEY => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ],
                "expected" => [],
            ],
            [
                "content" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ],
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ],
            ]
        ];
    }
}