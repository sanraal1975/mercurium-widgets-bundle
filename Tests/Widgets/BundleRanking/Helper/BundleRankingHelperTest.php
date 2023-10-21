<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleRanking\Helper;

use ArgumentCountError;
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
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $testHelper = new TestHelper();
        $this->testHelper = $testHelper;

        $this->valueObject = new BundleRankingValueObjectMock(
            $this->testHelper->getApi(),
            "es",
            "foo.bar",
            $this->testHelper->getPositiveValue()
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
     * @return void
     */
    public function testGetValueObject()
    {
        $helper = new BundleRankingHelper($this->valueObject);

        $helperObject = $helper->getValueObject();

        $this->assertEquals($this->valueObject, $helperObject);
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
        $file = $this->cwd . "/Tests/Widgets/BundleRanking/Helper/BundleRankingJson.json";

        return [
            [
                "filePath" => "",
                "expected" => ""
            ],
            [
                "filePath" => $file,
                "expected" => '{"es":1}'
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
        return [
            [
                "content" => "",
                "expected" => []
            ],
            [
                "content" => '{"es":{"id":1}}',
                "expected" => ["id" => 1]
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
                "content" => [["id" => 1]],
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