<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleOpinion\Helper;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleOpinion\ValueObject\BundleOpinionValueObjectMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\Helper\BundleOpinionHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\ValueObject\BundleOpinionValueObject;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class BundleOpinionHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleOpinion\Helper
 */
class BundleOpinionHelperTest extends TestCase
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
     * @throws Exception
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
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new BundleOpinionHelper();
    }

    /**
     * @return void
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleOpinionHelper(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetValueObject()
    {
        $valueObject = new BundleOpinionValueObjectMock(
            $this->api,
            $this->testHelper->getPositiveValue(),
            "",
            0,
            0
        );

        $helper = new BundleOpinionHelper($valueObject);
        $valueObject = $helper->getValueObject();

        $this->assertInstanceOf(BundleOpinionValueObject::class, $valueObject);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetSponsorImageReturnEmpty()
    {
        $valueObject = new BundleOpinionValueObjectMock(
            $this->api,
            0,
            "",
            0,
            0
        );

        $helper = new BundleOpinionHelper($valueObject);
        $image = $helper->getSponsorImage();

        $this->assertEmpty($image);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetSponsorImageReturnValue()
    {
        $valueObject = new BundleOpinionValueObjectMock(
            $this->api,
            1,
            "",
            0,
            0
        );

        $helper = new BundleOpinionHelper($valueObject);
        $image = $helper->getSponsorImage();

        $expected = [
            EntityConstants::ID_FIELD_KEY => 1,
            EntityConstants::SEARCHABLE_FIELD_KEY => true
        ];

        $this->assertEquals($expected, $image);
    }

    /**
     * @dataProvider getManualArticles
     *
     * @return void
     * @throws Exception
     */
    public function testGetManualArticles($valueObject, $expected)
    {
        $helper = new BundleOpinionHelper($valueObject);
        $articles = $helper->getManualArticles();

        $this->assertEquals($expected, $articles);
    }

    /**
     * @return array[]
     */
    public function getManualArticles(): array
    {
        return [
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->api,
                    1,
                    "",
                    0,
                    0
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->api,
                    1,
                    "1",
                    0,
                    0
                ),
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
        ];
    }

    /**
     * @dataProvider getAutomaticArticles
     *
     * @return void
     * @throws Exception
     */
    public function testGetAutomaticArticles($valueObject, $expected)
    {
        $helper = new BundleOpinionHelper($valueObject);
        $articles = $helper->getAutomaticArticles();

        $this->assertEquals($expected, $articles);
    }

    /**
     * @return array[]
     */
    public function getAutomaticArticles(): array
    {
        return [
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->api,
                    1,
                    "",
                    0,
                    0
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->api,
                    1,
                    "",
                    1,
                    0
                ),
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->api,
                    1,
                    "",
                    1,
                    1
                ),
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
        ];
    }
}