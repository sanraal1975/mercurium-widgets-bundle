<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleBreakingNews\Helper;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleBreakingNews\BundleBreakingNewsValueObjectMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Helper\BundleBreakingNewsHelper;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class BundleBreakingNewsHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleBreakingNews\Helper
 */
class BundleBreakingNewsHelperTest extends TestCase
{
    /**
     * @var BundleBreakingNewsValueObjectMock
     */
    private $valueObjectDev;

    /**
     * @var BundleBreakingNewsValueObjectMock
     */
    private $valueObjectProd;

    /**
     * @var false|string
     */
    private $cwd;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $this->valueObjectDev = new BundleBreakingNewsValueObjectMock(
            "dev",
            "es",
            "foo",
            "bar",
            "https://www.foo.bar",
            "breaking_news.json",
            "breaking_news.json",
            "breaking_news.json"
        );

        $this->valueObjectProd = new BundleBreakingNewsValueObjectMock(
            "prod",
            "es",
            "foo",
            "bar",
            "https://www.foo.bar",
            "breaking_news.json",
            "breaking_news.json",
            "breaking_news.json"
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

        $helper = new BundleBreakingNewsHelper();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleBreakingNewsHelper(null);
    }

    /**
     * @return void
     */
    public function testGetValueObject()
    {
        $helper = new BundleBreakingNewsHelper($this->valueObjectDev);

        $helperObject = $helper->getValueObject();

        $this->assertEquals($this->valueObjectDev, $helperObject);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testFileExistsThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new BundleBreakingNewsHelper($this->valueObjectDev);
        $result = $helper->fileExists();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testFileExistsThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleBreakingNewsHelper($this->valueObjectDev);
        $result = $helper->fileExists(null);
    }

    /**
     * @dataProvider fileExistsValues
     *
     * @return void
     * @throws Exception
     */
    public function testFileExists($valueObject, $filePath, $expected)
    {
        $helper = new BundleBreakingNewsHelper($valueObject);

        $result = $helper->fileExists($filePath);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function fileExistsValues(): array
    {
        $fileExists = $this->cwd . "/Tests/Widgets/BundleBreakingNews/Helper/BundleBreakingNews.json";
        $fileNotExists = $this->cwd . "/Tests/Widgets/BundleBreakingNews/Helper/BundleBreakingNewss.json";

        return [
            [
                "valueObject" => $this->valueObjectDev,
                "filePath" => "",
                "expected" => false
            ],
            [
                "valueObject" => $this->valueObjectProd,
                "filePath" => $fileExists,
                "expected" => true
            ],
            [
                "valueObject" => $this->valueObjectProd,
                "filePath" => $fileNotExists,
                "expected" => false
            ],
            [
                "valueObject" => $this->valueObjectDev,
                "filePath" => $fileExists,
                "expected" => true
            ],
            [
                "valueObject" => $this->valueObjectDev,
                "filePath" => $fileNotExists,
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

        $helper = new BundleBreakingNewsHelper($this->valueObjectDev);
        $result = $helper->getJsonContent();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetJsonContentThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleBreakingNewsHelper($this->valueObjectDev);
        $result = $helper->getJsonContent(null);
    }

    /**
     * @dataProvider getJsonContent
     *
     * @return void
     * @throws Exception
     */
    public function testGetJsonContent($valueObject, $filePath, $expected)
    {
        $helper = new BundleBreakingNewsHelper($valueObject);

        $result = $helper->getJsonContent($filePath);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getJsonContent(): array
    {
        $fileExists = $this->cwd . "/Tests/Widgets/BundleBreakingNews/Helper/BundleBreakingNews.json";

        return [
            [
                "valueObject" => $this->valueObjectDev,
                "filePath" => "",
                "expected" => ""
            ],
            [
                "valueObject" => $this->valueObjectProd,
                "filePath" => $fileExists,
                "expected" => '{"es":1}'
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
        $helper = new BundleBreakingNewsHelper($valueObject);
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
                "valueObject" =>new BundleBreakingNewsValueObjectMock(
                    "dev",
                    "es",
                    "foo",
                    "bar",
                    "https://www.foo.bar",
                    "dev_breaking_news.json",
                    "prod_breaking_news.json",
                    ""
                ),
                "expected" => ""
            ],
            [
                "valueObject" =>new BundleBreakingNewsValueObjectMock(
                    "dev",
                    "es",
                    "foo",
                    "bar",
                    "https://www.foo.bar",
                    "dev_breaking_news.json",
                    "prod_breaking_news.json",
                    "breaking_news_es.json"
                ),
                "expected" => "dev_breaking_news.json"
            ],
            [
                "valueObject" =>new BundleBreakingNewsValueObjectMock(
                    "prod",
                    "es",
                    "foo",
                    "bar",
                    "https://www.foo.bar",
                    "dev_breaking_news.json",
                    "prod_breaking_news.json",
                    "breaking_news_es.json"
                ),
                "expected" => "prod_breaking_news.json"
            ]
        ];
    }
}