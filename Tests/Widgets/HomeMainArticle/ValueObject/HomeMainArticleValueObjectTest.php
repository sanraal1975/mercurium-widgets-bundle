<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\HomeMainArticle\ValueObject;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers\NormalizerMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\HomeMainArticle\ValueObject\HomeMainArticleValueObject;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class HomeMainArticleValueObjectTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\HomeMainArticle\ValueObject
 */
class HomeMainArticleValueObjectTest extends TestCase
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

        $valueObject = new HomeMainArticleValueObject();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @return void
     */
    public function testConstructThrowsTypeErrorException($api, $articlesIds, $normalizer)
    {
        $this->expectException(TypeError::class);

        $valueObject = new HomeMainArticleValueObject($api, $articlesIds, $normalizer);
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

        $valueObject = new HomeMainArticleValueObject(
            $this->api,
            "",
            $normalizer
        );

        $this->assertEquals($this->api, $valueObject->getApi());
        $this->assertEquals("", $valueObject->getArticlesIds());
        $this->assertEquals($normalizer, $valueObject->getNormalizer());
    }
}