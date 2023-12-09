<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleOpinion\Helper;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
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
     * @var false|string
     */
    private $cwd;

    /**
     * @var string
     */
    private $fileExists;

    /**
     * @var string
     */
    private $fileNoExists;

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

        $this->cwd = getcwd();
        $this->fileExists = $this->cwd . "/Tests/Widgets/BundleOpinion/Helper/BundleOpinionJson.json";
        $this->fileNoExists = $this->cwd . "/Tests/Widgets/BundleOpinion/Helper/BundleROpinionJsons.json";
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
            0,
            BundleConstants::LOCALE_CA
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
            0,
            BundleConstants::LOCALE_CA
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
            0,
            BundleConstants::LOCALE_CA
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
                    0,
                    BundleConstants::LOCALE_CA
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->api,
                    1,
                    "1",
                    0,
                    0,
                    BundleConstants::LOCALE_CA
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
    public function testGetAutomaticArticles($valueObject, $deniedArticles, $expected)
    {
        $helper = new BundleOpinionHelper($valueObject);
        $articles = $helper->getAutomaticArticles($deniedArticles);

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
                    0,
                    BundleConstants::LOCALE_CA
                ),
                "deniedArticles" => "",
                "expected" => []
            ],
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->api,
                    1,
                    "",
                    1,
                    0,
                    BundleConstants::LOCALE_CA
                ),
                "deniedArticles" => "",
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
                    1,
                    BundleConstants::LOCALE_CA
                ),
                "deniedArticles" => "",
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
                    1,
                    BundleConstants::LOCALE_CA
                ),
                "deniedArticles" => "1",
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
     * @dataProvider getJsonFilePath
     *
     * @return void
     * @throws Exception
     */
    public function testGetJsonFilePath($valueObject, $expected)
    {
        $helper = new BundleOpinionHelper($valueObject);
        $result = $helper->getJsonFilePath();

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getJsonFilePath(): array
    {
        return [
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->api,
                    1,
                    "1",
                    1,
                    1,
                    BundleConstants::LOCALE_CA,
                    ""
                ),
                "expected" => ""
            ],
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->api,
                    1,
                    "1",
                    1,
                    1,
                    BundleConstants::LOCALE_CA,
                    "foo.bar",
                    BundleConstants::ENVIRONMENT_DEV,
                    "dev.foo.bar",
                    "prod.foo.bar"
                ),
                "expected" => "dev.foo.bar"
            ],
            [
                "valueObject" => new BundleOpinionValueObjectMock(
                    $this->api,
                    1,
                    "1",
                    1,
                    1,
                    BundleConstants::LOCALE_CA,
                    "foo.bar",
                    BundleConstants::ENVIRONMENT_PROD,
                    "dev.foo.bar",
                    "prod.foo.bar"
                ),
                "expected" => "prod.foo.bar"
            ]
        ];
    }

    /**
     * @dataProvider dataProviderFileExists
     *
     * @return void
     * @throws Exception
     */
    public function testFileExists($filePath, $expected)
    {
        $valueObject = new BundleOpinionValueObjectMock($this->api);
        $helper = new BundleOpinionHelper($valueObject);

        $result = $helper->fileExists($filePath);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function dataProviderFileExists(): array
    {
        return [
            [
                "filePath" => "",
                "expected" => false
            ],
            [
                "filePath" => "foo.bar",
                "expected" => false
            ]
        ];
    }

    /**
     * @dataProvider getJsonContent
     *
     * @return void
     * @throws Exception
     */
    public function testGetJsonContent($jsonFilePath, $expected)
    {
        $valueObject = new BundleOpinionValueObjectMock($this->api);
        $helper = new BundleOpinionHelper($valueObject);

        $result = $helper->getJsonContent($jsonFilePath);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getJsonContent(): array
    {
        return [
            [
                "jsonFilePath" => "",
                "expected" => ""
            ],
            [
                "jsonFilePath" => $this->fileExists,
                "expected" => '{"es":[{"id":1}]}'
            ]
        ];
    }

    /**
     * @dataProvider getLocaleIds
     *
     * @return void
     * @throws Exception
     */
    public function testGetLocaleIds($jsonContent, $expected)
    {
        $valueObject = new BundleOpinionValueObjectMock($this->api);
        $helper = new BundleOpinionHelper($valueObject);

        $result = $helper->getLocaleIds($jsonContent);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getLocaleIds(): array
    {
        return [
            [
                "jsonContent" => "",
                "expected" => []
            ],
            [
                "jsonContent" => '{"ca":[{"id":1}]}',
                "expected" => [[EntityConstants::ID_FIELD_KEY => 1]]
            ]
        ];
    }

    /**
     * @dataProvider getArticlesIdsFromArray
     *
     * @return void
     * @throws Exception
     */
    public function testGetArticlesIdsFromArray($localeIds, $expected)
    {
        $valueObject = new BundleOpinionValueObjectMock($this->api);
        $helper = new BundleOpinionHelper($valueObject);

        $result = $helper->getArticlesIdsFromArray($localeIds);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getArticlesIdsFromArray(): array
    {
        return [
            [
                "localeIds" => [],
                "expected" => ""
            ],
            [
                "localeIds" => [[EntityConstants::ID_FIELD_KEY => 1]],
                "expected" => "1"
            ]
        ];
    }
}