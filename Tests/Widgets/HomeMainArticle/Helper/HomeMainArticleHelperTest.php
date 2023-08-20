<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\HomeMainArticle\Helper;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers\NormalizerMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\HomeMainArticle\Helper\HomeMainArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\HomeMainArticle\ValueObject\HomeMainArticleValueObject;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class HomeMainArticleHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\HomeMainArticle\Helper
 */
class HomeMainArticleHelperTest extends TestCase
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

        $helper = new HomeMainArticleHelper();
        $articles = $helper->getArticles();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetArticlesThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new HomeMainArticleHelper();
        $articles = $helper->getArticles(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetArticlesThrowsExceptionMessageEntityIdGreaterThanZero()
    {
        $this->expectExceptionMessage(ArticleHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new HomeMainArticleHelper();
        $articles = $helper->getArticles(
            new HomeMainArticleValueObject(
                $this->api,
                $this->testHelper->getZeroOrNegativeValueAsString(),
                new EntityNormalizer([new NormalizerMock()])
            )
        );
    }

    /**
     * @dataProvider getArticlesReturnValue
     *
     * @return void
     * @throws Exception
     */
    public function testGetArticlesReturnValue($valueObject, $expected)
    {
        $helper = new HomeMainArticleHelper();
        $articles = $helper->getArticles($valueObject);

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
                "valueObject" => new HomeMainArticleValueObject(
                    $this->api,
                    "",
                    $normalizer
                ),
                "expected" => []
            ],
            [
                "valueObject" => new HomeMainArticleValueObject(
                    $this->api,
                    $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                    $normalizer
                ),
                "expected" => []
            ],
            [
                "valueObject" => new HomeMainArticleValueObject(
                    $this->api,
                    $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY_SEARCHABLE,
                    $normalizer
                ),
                "expected" => []
            ],
            [
                "valueObject" => new HomeMainArticleValueObject(
                    $this->api,
                    "1",
                    $normalizer
                ),
                "expected" => [
                    [
                        BundleConstants::ID_FIELD_KEY => 1,
                        BundleConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "valueObject" => new HomeMainArticleValueObject(
                    $this->api,
                    "1," . $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                    $normalizer
                ),
                "expected" => [
                    [
                        BundleConstants::ID_FIELD_KEY => 1,
                        BundleConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "valueObject" => new HomeMainArticleValueObject(
                    $this->api,
                    "1," . $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY_SEARCHABLE,
                    $normalizer
                ),
                "expected" => [
                    [
                        BundleConstants::ID_FIELD_KEY => 1,
                        BundleConstants::SEARCHABLE_FIELD_KEY => true
                    ]
                ]
            ],
            [
                "valueObject" => new HomeMainArticleValueObject(
                    $this->api,
                    "1,2",
                    $normalizer
                ),
                "expected" => [
                    [
                        BundleConstants::ID_FIELD_KEY => 1,
                        BundleConstants::SEARCHABLE_FIELD_KEY => true
                    ],
                    [
                        BundleConstants::ID_FIELD_KEY => 2,
                        BundleConstants::SEARCHABLE_FIELD_KEY => true
                    ],
                ]
            ],
        ];
    }
}