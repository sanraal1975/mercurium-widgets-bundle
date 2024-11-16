<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleGalleryHome\Normalizer;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\GalleryNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleGalleryHome\ValueObject\BundleGalleryHomeValueObjectMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Normalizer\BundleGalleryHomeNormalizer;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class BundleGalleryHomeNormalizerTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleGalleryHome\Normalizer
 */
class BundleGalleryHomeNormalizerTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private $testHelper;

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
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new BundleGalleryHomeNormalizer();
    }

    /**
     * @return void
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new BundleGalleryHomeNormalizer(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $normalizer = new BundleGalleryHomeNormalizer(
            new BundleGalleryHomeValueObjectMock(
                $this->testHelper->getApi(),
                $this->testHelper->getPositiveValue(),
                new EntityNormalizer([new GalleryNormalizer($this->testHelper->getApi())])
            )
        );

        $result = $normalizer->normalize();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testNormalizeThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $normalizer = new BundleGalleryHomeNormalizer(
            new BundleGalleryHomeValueObjectMock(
                $this->testHelper->getApi(),
                $this->testHelper->getPositiveValue(),
                new EntityNormalizer([new GalleryNormalizer($this->testHelper->getApi())])
            )
        );

        $result = $normalizer->normalize(null);
    }

    /**
     * @dataProvider normalize
     *
     * @return void
     * @throws Exception
     */
    public function testNormalize($valueObject, $entity, $expected)
    {
        $normalizer = new BundleGalleryHomeNormalizer($valueObject);

        $result = $normalizer->normalize($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     * @throws Exception
     */
    public function normalize(): array
    {
        $positiveValue = $this->testHelper->getPositiveValue();

        return [
            [
                "valueObject" => new BundleGalleryHomeValueObjectMock(
                    $this->testHelper->getApi(),
                    $positiveValue,
                    new EntityNormalizer([new GalleryNormalizer($this->testHelper->getApi())])
                ),
                "entity" => [],
                "expected" => []
            ],
            [
                "valueObject" => new BundleGalleryHomeValueObjectMock(
                    $this->testHelper->getApi(),
                    $positiveValue,
                    new EntityNormalizer([new GalleryNormalizer($this->testHelper->getApi())])
                ),
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => $positiveValue
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => $positiveValue,
                    EntityConstants::TOTAL_ASSETS_FIELD_KEY => 0
                ],
            ],
            [
                "valueObject" => new BundleGalleryHomeValueObjectMock(
                    $this->testHelper->getApi(),
                    $positiveValue,
                    new EntityNormalizer([new GalleryNormalizer($this->testHelper->getApi())])
                ),
                "entity" => [
                    EntityConstants::ID_FIELD_KEY => $positiveValue,
                    EntityConstants::ASSETS_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1
                        ]
                    ]
                ],
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => $positiveValue,
                    EntityConstants::TOTAL_ASSETS_FIELD_KEY => 1,
                    EntityConstants::ASSETS_FIELD_KEY => [
                        [
                            EntityConstants::ID_FIELD_KEY => 1,
                            EntityConstants::SEARCHABLE_FIELD_KEY => true,
                            EntityConstants::ORIENTATION_FIELD_KEY => EntityConstants::IMAGE_ORIENTATION_SQUARE,
                        ]
                    ]
                ],
            ]
        ];

    }
}