<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHomeMainArticle\Helper;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers\NormalizerMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleHomeMainArticle\ValueObject\BundleHomeMainArticleValueObjectMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Helper\BundleHomeMainArticleHelper;
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
    public function testGetArticlesThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new BundleHomeMainArticleHelper();
        $articles = $helper->getArticles();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetArticlesThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new BundleHomeMainArticleHelper();
        $articles = $helper->getArticles();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetArticlesThrowsExceptionMessageEntityIdGreaterThanZero()
    {
        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $normalizer = new EntityNormalizer([new NormalizerMock()]);

        $valueObject = new BundleHomeMainArticleValueObjectMock(
            $this->api,
            $this->testHelper->getZeroOrNegativeValue(),
            $normalizer
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
                "valueObject" => new BundleHomeMainArticleValueObjectMock(
                    $this->api,
                    "",
                    $normalizer
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleHomeMainArticleValueObjectMock(
                    $this->api,
                    $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                    $normalizer
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleHomeMainArticleValueObjectMock(
                    $this->api,
                    $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY_SEARCHABLE,
                    $normalizer
                ),
                "expected" => []
            ],
            [
                "valueObject" => new BundleHomeMainArticleValueObjectMock(
                    $this->api,
                    "1",
                    $normalizer
                ),
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "valueObject" => new BundleHomeMainArticleValueObjectMock(
                    $this->api,
                    "1," . $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                    $normalizer
                ),
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "valueObject" => new BundleHomeMainArticleValueObjectMock(
                    $this->api,
                    "1," . $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY_SEARCHABLE,
                    $normalizer
                ),
                "expected" => [
                    [
                        EntityConstants::ID_FIELD_KEY => 1,
                        EntityConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "valueObject" => new BundleHomeMainArticleValueObjectMock(
                    $this->api,
                    "1,2",
                    $normalizer
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