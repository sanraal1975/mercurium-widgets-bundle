<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHomeMainArticle\Resolver;

use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityDynamicFieldsNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleHomeMainArticle\ValueObject\BundleHomeMainArticleValueObjectMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Resolver\BundleHomeMainArticleResolver;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class BundleHomeMainArticleResolverTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHomeMainArticle\Resolver
 */
class BundleHomeMainArticleResolverTest extends TestCase
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
    public function testConstruct()
    {
        $valueObject = new BundleHomeMainArticleValueObjectMock(
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
        );

        $normalizer = new EntityNormalizer(
            [
                new EntityDynamicFieldsNormalizer([])
            ]
        );

        new BundleHomeMainArticleResolver($valueObject, $normalizer);
    }

    /**
     * @dataProvider resolve
     *
     * @return void
     * @throws Exception
     */
    public function testResolve($valueObject, $expected)
    {
        $normalizer = new EntityNormalizer(
            [
                new EntityDynamicFieldsNormalizer([])
            ]
        );

        $resolver = new BundleHomeMainArticleResolver($valueObject, $normalizer);

        $result = $resolver->resolve();

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function resolve(): array
    {
        $format = "format-1";
        $showImage = true;
        $showSubtitle = true;
        $showRelatedContent = true;
        $showSponsor = true;
        $showNumComments = true;

        return [
            [
                "valueObject" => new BundleHomeMainArticleValueObjectMock(
                    $this->api,
                    $this->testHelper::API_LOCALE,
                    $this->testHelper::API_SUBSITE,
                    $this->testHelper::TRANSLATION_GROUP,
                    $format,
                    $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                    $showSubtitle,
                    $showImage,
                    $showRelatedContent,
                    $showNumComments,
                    $showSponsor
                ),
                "expected" => [
                    "articles" => [],
                    "format" => $format,
                    "locale" => $this->testHelper::API_LOCALE,
                    "translationGroup" => $this->testHelper::TRANSLATION_GROUP,
                    "subSiteAcronym" => $this->testHelper::API_SUBSITE,
                    "showImage" => $showImage,
                    "showNumComments" => $showNumComments,
                    "showRelatedContent" => $showRelatedContent,
                    "showSponsor" => $showSponsor,
                    "showSubtitle" => $showSubtitle,
                ]
            ],
        ];
    }
}