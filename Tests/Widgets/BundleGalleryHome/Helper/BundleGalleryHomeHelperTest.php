<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleGalleryHome\Helper;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\GalleryNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleGalleryHome\ValueObject\BundleGalleryHomeValueObjectMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Helper\BundleGalleryHomeHelper;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class BundleGalleryHomeHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleGalleryHome\Helper
 */
class BundleGalleryHomeHelperTest extends TestCase
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

        $testHelper = new TestHelper();
        $this->testHelper = $testHelper;
        $this->api = $testHelper->getApi();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new BundleGalleryHomeHelper();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleGalleryHomeHelper(null);
    }

    /**
     * @dataProvider getGallery
     *
     * @return void
     * @throws Exception
     */
    public function testGetGallery($valueObject, $expected)
    {
        $helper = new BundleGalleryHomeHelper($valueObject);
        $gallery = $helper->getGalleryFromApi();

        $this->assertEquals($expected, $gallery);
    }

    /**
     *
     * @return array[]
     * @throws Exception
     */
    public function getGallery(): array
    {
        $api = $this->testHelper->getApi();
        $galleryId = $this->testHelper->getPositiveValue();

        return [
            [
                "valueObject" => new BundleGalleryHomeValueObjectMock(
                    $api,
                    $galleryId,
                    new EntityNormalizer(
                        [
                            new GalleryNormalizer($api)
                        ]
                    )
                ),
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => $galleryId,
                    EntityConstants::SEARCHABLE_FIELD_KEY => true
                ]
            ],
            [
                "valueObject" => new BundleGalleryHomeValueObjectMock(
                    $api,
                    TestHelper::ENTITY_ID_TO_RETURN_EMPTY,
                    new EntityNormalizer(
                        [
                            new GalleryNormalizer($api)
                        ]
                    )
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleGalleryHomeValueObjectMock(
                    $api,
                    TestHelper::ENTITY_ID_TO_RETURN_EMPTY_SEARCHABLE,
                    new EntityNormalizer(
                        [
                            new GalleryNormalizer($api)
                        ]
                    )
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleGalleryHomeValueObjectMock(
                    $api,
                    $this->testHelper->getZeroOrNegativeValue(),
                    new EntityNormalizer(
                        [
                            new GalleryNormalizer($api)
                        ]
                    )
                ),
                "expected" => []
            ]
        ];
    }
}