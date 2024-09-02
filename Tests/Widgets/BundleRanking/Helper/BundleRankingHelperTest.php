<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleRanking\Helper;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleRanking\ValueObject\BundleRankingValueObjectMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Helper\BundleRankingHelper;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class BundleRankingHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleRanking\Helper
 */
class BundleRankingHelperTest extends TestCase
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
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $testHelper = new TestHelper();
        $this->testHelper = $testHelper;

        $this->cwd = getcwd();
        $this->fileExists = $this->cwd . "/Tests/Widgets/BundleRanking/Helper/BundleRankingJson.json";
        $this->fileNoExists = $this->cwd . "/Tests/Widgets/BundleRanking/Helper/BundleRankingJsons.json";

        $this->valueObject = new BundleRankingValueObjectMock(
            $this->testHelper->getApi(),
            "es",
            "foo.bar",
            $this->testHelper->getPositiveValue(),
            "env",
            $this->fileExists,
            $this->fileExists,
            "https://www.foo.bar",
            "foo",
            "bar"
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new BundleRankingHelper();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleRankingHelper(null);
    }

    /**
     * @dataProvider getJsonFilePath
     *
     * @return void
     */
    public function testGetJsonFilePath($valueObject, $expected)
    {
        $helper = new BundleRankingHelper($valueObject);
        $result = $helper->getJsonFilePath();

        $this->assertEquals($result, $expected);
    }

    /**
     * @return array[]
     */
    public function getJsonFilePath(): array
    {
        return [
            [
                "valueObject" => new BundleRankingValueObjectMock(
                    $this->testHelper->getApi(),
                    BundleConstants::LOCALE_CA,
                    "",
                    PHP_INT_MAX,
                    BundleConstants::ENVIRONMENT_DEV,
                    "",
                    "",
                    "https://www.foo.bar",
                    "foo",
                    "bar"
                ),
                "expected" => ""
            ],
            [
                "valueObject" => new BundleRankingValueObjectMock(
                    $this->testHelper->getApi(),
                    BundleConstants::LOCALE_CA,
                    "dummy_json.json",
                    PHP_INT_MAX,
                    BundleConstants::ENVIRONMENT_DEV,
                    "dev_json.json",
                    "",
                    "https://www.foo.bar",
                    "foo",
                    "bar"
                ),
                "expected" => "dev_json.json"
            ],
            [
                "valueObject" => new BundleRankingValueObjectMock(
                    $this->testHelper->getApi(),
                    BundleConstants::LOCALE_CA,
                    "dummy_json.json",
                    PHP_INT_MAX,
                    BundleConstants::ENVIRONMENT_PROD,
                    "",
                    "prod_json.json",
                    "https://www.foo.bar",
                    "foo",
                    "bar"
                ),
                "expected" => "prod_json.json"
            ]
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testFileExistsThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new BundleRankingHelper($this->valueObject);

        $content = $helper->fileExists();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testFileExistsThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleRankingHelper($this->valueObject);

        $content = $helper->fileExists(null);
    }

    /**
     * @dataProvider dpFileExists
     *
     * @return void
     * @throws Exception
     */
    public function testFileExists($filePath, $expected)
    {
        $helper = new BundleRankingHelper($this->valueObject);

        $result = $helper->fileExists($filePath);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function dpFileExists(): array
    {
        return [
            [
                "filePath" => "",
                "expected" => false
            ],
            [
                "filePath" => $this->fileExists,
                "expected" => true
            ],
            [
                "filePath" => $this->fileNoExists,
                "expected" => false
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetJsonContentThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new BundleRankingHelper($this->valueObject);

        $content = $helper->getJsonContent();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetJsonContentThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleRankingHelper($this->valueObject);

        $content = $helper->getJsonContent(null);
    }

    /**
     * @dataProvider getJsonContent
     *
     * @return void
     * @throws Exception
     */
    public function testGetJsonContent($filePath, $expected)
    {
        $helper = new BundleRankingHelper($this->valueObject);

        $content = $helper->getJsonContent($filePath);

        $this->assertEquals($expected, $content);
    }

    /**
     * @return array[]
     */
    public function getJsonContent(): array
    {
        $expected[BundleConstants::LOCALE_ES] = 1;
        $expected = json_encode($expected);

        return [
            [
                "filePath" => "",
                "expected" => ""
            ],
            [
                "filePath" => $this->fileExists,
                "expected" => $expected
            ]
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetLocaleIdsThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new BundleRankingHelper($this->valueObject);

        $ids = $helper->getLocaleIds();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetLocaleIdsThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleRankingHelper($this->valueObject);

        $ids = $helper->getLocaleIds(null);
    }

    /**
     * @dataProvider getLocaleIds
     *
     * @return void
     * @throws Exception
     */
    public function testGetLocaleIds($content, $expected)
    {
        $helper = new BundleRankingHelper($this->valueObject);

        $ids = $helper->getLocaleIds($content);

        $this->assertEquals($expected, $ids);
    }

    /**
     * @return array[]
     */
    public function getLocaleIds(): array
    {
        $content[BundleConstants::LOCALE_ES] = [EntityConstants::ID_FIELD_KEY => 1];
        $content = json_encode($content);

        return [
            [
                "content" => "",
                "expected" => []
            ],
            [
                "content" => $content,
                "expected" => [EntityConstants::ID_FIELD_KEY => 1]
            ]
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetArticlesIdsFromArrayThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new BundleRankingHelper($this->valueObject);

        $ids = $helper->getArticlesIdsFromArray();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetArticlesIdsFromArrayThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleRankingHelper($this->valueObject);

        $ids = $helper->getArticlesIdsFromArray(null);
    }

    /**
     * @dataProvider getArticlesIdsFromArray
     *
     * @return void
     * @throws Exception
     */
    public function testGetArticlesIdsFromArray($content, $expected)
    {
        $helper = new BundleRankingHelper($this->valueObject);

        $ids = $helper->getArticlesIdsFromArray($content);

        $this->assertEquals($expected, $ids);
    }

    /**
     * @return array[]
     */
    public function getArticlesIdsFromArray(): array
    {
        return [
            [
                "content" => [],
                "expected" => ""
            ],
            [
                "content" => [[EntityConstants::ID_FIELD_KEY => 1]],
                "expected" => "1"
            ]
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetArticlesThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new BundleRankingHelper($this->valueObject);

        $ids = $helper->getArticles();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetArticlesThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleRankingHelper($this->valueObject);

        $ids = $helper->getArticles(null);
    }

    /**
     * @dataProvider getArticles
     *
     * @return void
     * @throws Exception
     */
    public function testGetArticles($content, $expected)
    {
        $helper = new BundleRankingHelper($this->valueObject);
        $ids = $helper->getArticles($content);

        $this->assertEquals($expected, $ids);
    }

    /**
     * @return array[]
     */
    public function getArticles(): array
    {
        return [
            [
                "content" => "",
                "expected" => []
            ],
            [
                "content" => "1",
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ]
        ];
    }
}