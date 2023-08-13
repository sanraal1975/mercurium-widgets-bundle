<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\ValueObjects;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\RichSnippetPublisherValueObject;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class RichSnippetsValueObjectTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\ValueObjects
 */
class RichSnippetPublisherValueObjectTest extends TestCase
{
    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $valueObject = new RichSnippetPublisherValueObject();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @param $subSiteName
     * @param $subSiteUrl
     * @param $logo
     * @param $schemaSocialNetworks
     * @param $projectSocialNetworks
     *
     * @return void
     */
    public function testConstructThrowsTypeErrorException($subSiteName, $subSiteUrl, $logo, $schemaSocialNetworks, $projectSocialNetworks)
    {
        $this->expectException(TypeError::class);

        $valueObject = new RichSnippetPublisherValueObject($subSiteName, $subSiteUrl, $logo, $schemaSocialNetworks, $projectSocialNetworks);
    }

    /**
     * @return array[]
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "subSiteName" => null,
                "subSiteUrl" => "",
                "logo" => "",
                "schemaSocialNetworks" => "",
                "projectSocialNetwork" => "",
            ],
            [
                "subSiteName" => "",
                "subSiteUrl" => null,
                "logo" => "",
                "schemaSocialNetworks" => "",
                "projectSocialNetwork" => "",
            ],
            [
                "subSiteName" => "",
                "subSiteUrl" => "",
                "logo" => null,
                "schemaSocialNetworks" => "",
                "projectSocialNetwork" => "",
            ],
            [
                "subSiteName" => "",
                "subSiteUrl" => "",
                "logo" => [],
                "schemaSocialNetworks" => null,
                "projectSocialNetwork" => "",
            ],
            [
                "subSiteName" => "",
                "subSiteUrl" => "",
                "logo" => [],
                "schemaSocialNetworks" => "",
                "projectSocialNetwork" => null,
            ],
        ];
    }

    /**
     * @return void
     */
    public function testGetters()
    {
        $valueObject = new RichSnippetPublisherValueObject("foo", "www.foo.bar", [], "facebook", []);

        $this->assertEquals("foo", $valueObject->getSubSiteName());
        $this->assertEquals("www.foo.bar", $valueObject->getSubSiteUrl());
        $this->assertEquals([], $valueObject->getLogo());
        $this->assertEquals("facebook", $valueObject->getSchemaSocialNetworks());
        $this->assertEquals([], $valueObject->getProjectSocialNetworks());
    }
}