<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\RichSnippetsConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\RichSnippetsHelper;
use Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\SiteNavigationRichSnippetsResolver;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class SiteNavigationRichSnippetsResolverTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items
 */
class SiteNavigationRichSnippetsResolverTest extends TestCase
{
    /**
     * @dataProvider getConstructThrowsArgumentCountErrorException
     *
     * @param $siteName
     * @param $baseUrl
     *
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException($siteName, $baseUrl)
    {
        $this->expectException(ArgumentCountError::class);

        if (empty($siteName)) {
            $resolver = new SiteNavigationRichSnippetsResolver();
        } elseif (empty($baseUrl)) {
            $resolver = new SiteNavigationRichSnippetsResolver($siteName);
        }
    }

    /**
     * @return array
     */
    public function getConstructThrowsArgumentCountErrorException(): array
    {
        return [
            [
                "siteName" => null,
                "baseUrl" => null
            ],
            [
                "siteName" => "foo",
                "baseUrl" => null
            ],
        ];
    }

    /**
     * @dataProvider getConstructThrowsTypeErrorException
     *
     * @param $siteName
     * @param $baseUrl
     *
     * @return void
     */
    public function testConstructThrowsTypeErrorException($siteName, $baseUrl)
    {
        $this->expectException(TypeError::class);

        $resolver = new SiteNavigationRichSnippetsResolver($siteName, $baseUrl);
    }

    /**
     * @return array
     */
    public function getConstructThrowsTypeErrorException(): array
    {
        return [
            [
                "siteName" => null,
                "baseUrl" => null
            ],
            [
                "siteName" => "foo",
                "baseUrl" => null
            ],
            [
                "siteName" => null,
                "baseUrl" => "bar"
            ]
        ];
    }

    /**
     * @return void
     */
    public function testResolveThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $resolver = new SiteNavigationRichSnippetsResolver("foo", "https://foo.bar");

        $result = $resolver->resolve();
    }

    /**
     * @return void
     */
    public function testResolveThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $resolver = new SiteNavigationRichSnippetsResolver("foo", "https://foo.bar");

        $result = $resolver->resolve(null);
    }

    /**
     * @return void
     */
    public function testResolveReturnsEmpty()
    {
        $resolver = new SiteNavigationRichSnippetsResolver("foo", "https://foo.bar");

        $result = $resolver->resolve([]);
        $expected = "";

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     */
    public function testResolveReturnsValue()
    {
        $siteName = "foo";
        $baseUrl = "http://foo.bar";
        $fixedBaseUrl = "https://foo.bar";
        $itemTitle = "fooTitle";
        $itemPermalink = "/foobar";

        $resolver = new SiteNavigationRichSnippetsResolver($siteName, $baseUrl);
        $items = [["title" => $itemTitle, "permalink" => $itemPermalink]];

        $result = $resolver->resolve($items);

        $richSnippets = [
            "@context" => RichSnippetsConstants::CONTEXT,
            "@graph" => [
                [
                    "@id" => $fixedBaseUrl . " - " . $siteName,
                    "@type" => RichSnippetsConstants::TYPE_SITE_NAVIGATION_ELEMENT,
                    "name" => $itemTitle,
                    "url" => $fixedBaseUrl . $itemPermalink
                ]
            ]
        ];

        $helper = new RichSnippetsHelper();

        $richSnippets = $helper->wrap($richSnippets);

        $this->assertEquals($richSnippets, $result);
    }
}