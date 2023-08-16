<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\HomeMainArticle\ValueObject;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Comitium5\MercuriumWidgetsBundle\Widgets\HomeMainArticle\ValueObject\HomeMainArticleValueObject;
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
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $testHelper = new TestHelper();
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
    public function testConstructThrowsTypeErrorException($api, $articlesIds)
    {
        $this->expectException(TypeError::class);

        $valueObject = new HomeMainArticleValueObject($api, $articlesIds);
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
            ],
            [
                "api" => $this->api,
                "articlesIds" => null,
            ],
        ];
    }

    /**
     * @return void
     */
    public function testConstruct()
    {
        $valueObject = new HomeMainArticleValueObject($this->api, "");

        $this->assertEquals($this->api,$valueObject->getApi());
        $this->assertEquals("",$valueObject->getArticlesIds());
    }
}