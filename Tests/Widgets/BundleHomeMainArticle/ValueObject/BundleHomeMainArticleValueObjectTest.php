<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHomeMainArticle\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\ValueObject\BundleHomeMainArticleValueObject;
use PHPUnit\Framework\TestCase;

/**
 * Class BundleHomeMainArticleValueObjectTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHomeMainArticle\ValueObject
 */
class BundleHomeMainArticleValueObjectTest extends TestCase
{
    /**
     * @var BundleHomeMainArticleValueObject
     */
    private $valueObject;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $helper = new TestHelper();
        $api = $helper->getApi();
        $locale = "es";
        $subSiteAcronym = "foo";
        $translationGroup = "bar";
        $format = "format-1";
        $articlesIds = "1,2";
        $showSubtitle = false;
        $showImage = false;
        $showRelatedContent = false;
        $showNumComments = false;
        $showSponsor = false;

        $this->valueObject = new BundleHomeMainArticleValueObject(
            $api,
            $locale,
            $subSiteAcronym,
            $translationGroup,
            $format,
            $articlesIds,
            $showSubtitle,
            $showImage,
            $showRelatedContent,
            $showNumComments,
            $showSponsor
        );
    }

    /**
     * @return void
     */
    public function testGetApi()
    {
        $result = $this->valueObject->getApi();

        $this->assertInstanceOf(Client::class, $result);
    }

    /**
     * @return void
     */
    public function testGetLocale()
    {
        $result = $this->valueObject->getLocale();

        $this->assertEquals("es", $result);
    }

    /**
     * @return void
     */
    public function testGetSubSiteAcronym()
    {
        $result = $this->valueObject->getSubSiteAcronym();

        $this->assertEquals("foo", $result);
    }

    /**
     * @return void
     */
    public function testGetTranslationGroup()
    {
        $result = $this->valueObject->getTranslationGroup();

        $this->assertEquals("bar", $result);
    }

    /**
     * @return void
     */
    public function testGetFormat()
    {
        $result = $this->valueObject->getFormat();

        $this->assertEquals("format-1", $result);
    }

    /**
     * @return void
     */
    public function testGetArticlesIds()
    {
        $result = $this->valueObject->getArticlesIds();

        $this->assertEquals("1,2", $result);
    }

    /**
     * @return void
     */
    public function testGetShowSubtitle()
    {
        $result = $this->valueObject->getShowSubtitle();

        $this->assertFalse($result);
    }

    /**
     * @return void
     */
    public function testGetShowImage()
    {
        $result = $this->valueObject->getShowImage();

        $this->assertFalse($result);
    }

    /**
     * @return void
     */
    public function testGetShowRelatedContent()
    {
        $result = $this->valueObject->getShowRelatedContent();

        $this->assertFalse($result);
    }

    /**
     * @return void
     */
    public function testGetShowNumComments()
    {
        $result = $this->valueObject->getShowNumComments();

        $this->assertFalse($result);
    }

    /**
     * @return void
     */
    public function testGetShowSponsor()
    {
        $result = $this->valueObject->getShowSponsor();

        $this->assertFalse($result);
    }
}