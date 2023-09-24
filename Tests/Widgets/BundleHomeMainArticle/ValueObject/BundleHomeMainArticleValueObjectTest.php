<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHomeMainArticle\ValueObject;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers\NormalizerMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\ValueObject\BundleHomeMainArticleValueObject;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class BundleHomeMainArticleValueObjectTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHomeMainArticle\ValueObject
 */
class BundleHomeMainArticleValueObjectTest extends TestCase
{
    /**
     * @var ClientMock
     */
    private $api;

    /**
     * @var TestHelper
     */
    private $testHelper;

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
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $valueObject = new BundleHomeMainArticleValueObject();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @return void
     */
    public function testConstructThrowsTypeErrorException($api, $articlesIds, $normalizer)
    {
        $this->expectException(TypeError::class);

        $valueObject = new BundleHomeMainArticleValueObject($api, $articlesIds, $normalizer);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "api" => null,
                "articlesIds" => null,
                "normalizer" => null
            ],
            [
                "api" => $this->api,
                "articlesIds" => null,
                "normalizer" => null
            ],
            [
                "api" => $this->api,
                "articlesIds" => $this->testHelper->getPositiveValueAsString(),
                "normalizer" => null
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstruct()
    {
        $normalizer = new EntityNormalizer([new NormalizerMock()]);

        $valueObject = new BundleHomeMainArticleValueObject(
            $this->api,
            "",
            $normalizer
        );

        $this->assertEquals($this->api, $valueObject->getApi());
        $this->assertEquals("", $valueObject->getArticlesIds());
        $this->assertEquals($normalizer, $valueObject->getNormalizer());
    }
}