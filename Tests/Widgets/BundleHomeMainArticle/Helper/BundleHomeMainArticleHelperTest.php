<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHomeMainArticle\Helper;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers\NormalizerMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Helper\BundleHomeMainArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Interfaces\BundleHomeMainArticleInterface;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\ValueObject\BundleHomeMainArticleValueObject;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class BundleHomeMainArticleHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHomeMainArticle\Helper
 */
class BundleHomeMainArticleHelperTest extends TestCase
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

        $helper = new BundleHomeMainArticleHelper();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleHomeMainArticleHelper(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetValueObject()
    {
        $normalizer = new EntityNormalizer([new NormalizerMock()]);

        $valueObject = new BundleHomeMainArticleValueObject(
            $this->api,
            "es",
            "mercurium",
            "default",
            "format-1",
            "1",
            true,
            true,
            true,
            true,
            true,
            "1"
        );

        $helper = new BundleHomeMainArticleHelper($valueObject);
        $valueObject = $helper->getValueObject();

        $this->assertInstanceOf(BundleHomeMainArticleInterface::class, $valueObject);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetArticlesThrowsExceptionMessageEntityIdGreaterThanZero()
    {
        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $normalizer = new EntityNormalizer([new NormalizerMock()]);

        $valueObject = new BundleHomeMainArticleValueObject(
            $this->api,
            "es",
            "mercurium",
            "default",
            "format-1",
            $this->testHelper->getNegativeValue(),
            true,
            true,
            true,
            true,
            true
        );

        $helper = new BundleHomeMainArticleHelper($valueObject);
        $articles = $helper->getArticles();
    }

    /**
     * @dataProvider getArticlesReturnValue
     *
     * @return void
     * @throws Exception
     */
    public function testGetArticlesReturnValue($valueObject, $expected)
    {
        $helper = new BundleHomeMainArticleHelper($valueObject);
        $articles = $helper->getArticles();

        $this->assertEquals($expected, $articles);
    }

    /**
     * @return array[]
     * @throws Exception
     */
    public function getArticlesReturnValue(): array
    {
        $normalizer = new EntityNormalizer([new NormalizerMock()]);

        return [
            [
                "valueObject" => new BundleHomeMainArticleValueObject(
                    $this->api,
                    "es",
                    "mercurium",
                    "default",
                    "format-1",
                    "",
                    true,
                    true,
                    true,
                    true,
                    true
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleHomeMainArticleValueObject(
                    $this->api,
                    "es",
                    "mercurium",
                    "default",
                    "format-1",
                    $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                    true,
                    true,
                    true,
                    true,
                    true
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleHomeMainArticleValueObject(
                    $this->api,
                    "es",
                    "mercurium",
                    "default",
                    "format-1",
                    $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY_SEARCHABLE,
                    true,
                    true,
                    true,
                    true,
                    true
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleHomeMainArticleValueObject(
                    $this->api,
                    "es",
                    "mercurium",
                    "default",
                    "format-1",
                    "1",
                    true,
                    true,
                    true,
                    true,
                    true
                ),
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "valueObject" => new BundleHomeMainArticleValueObject(
                    $this->api,
                    "es",
                    "mercurium",
                    "default",
                    "format-1",
                    "1," . $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                    true,
                    true,
                    true,
                    true,
                    true
                ),
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "valueObject" => new BundleHomeMainArticleValueObject(
                    $this->api,
                    "es",
                    "mercurium",
                    "default",
                    "format-1",
                    "1," . $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY_SEARCHABLE,
                    true,
                    true,
                    true,
                    true,
                    true
                ),
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "valueObject" => new BundleHomeMainArticleValueObject(
                    $this->api,
                    "es",
                    "mercurium",
                    "default",
                    "format-1",
                    "1,2",
                    true,
                    true,
                    true,
                    true,
                    true
                ),
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ],
                    [
                        EntityConstants::ID_FIELD_KEY => 2,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ],
                ]
            ],
        ];
    }
}