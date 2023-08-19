<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Factories\RichSnippetsFactory;
use Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\OrganizationRichSnippetsResolver;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class OrganizationRichSnippetsResolverTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets
 */
class OrganizationRichSnippetsResolverTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $richSnippet = new OrganizationRichSnippetsResolver();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $richSnippet = new OrganizationRichSnippetsResolver(null);
    }

    /**
     * @dataProvider resolveReturnsValue
     *
     * @param $valueObject
     * @param $expected
     *
     * @return void
     * @throws Exception
     */
    public function testResolveReturnsValue($valueObject, $expected)
    {
        $richSnippet = new OrganizationRichSnippetsResolver($valueObject);

        $result = $richSnippet->resolve();

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function resolveReturnsValue(): array
    {
        $factory = new RichSnippetsFactory();

        return [
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    "",
                    "",
                    [],
                    "",
                    []
                ),
                "expected" => '<script type="application/ld+json">{"@context":"https://www.schema.org","@type":"Organization","name":"","url":"","logo":[],"sameAs":[]}</script>',
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    "Foo Bar",
                    "",
                    [],
                    "",
                    []
                ),
                "expected" => '<script type="application/ld+json">{"@context":"https://www.schema.org","@type":"Organization","name":"Foo Bar","url":"","logo":[],"sameAs":[]}</script>',
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    "",
                    "www.foo.bar",
                    [],
                    "",
                    []
                ),
                "expected" => '<script type="application/ld+json">{"@context":"https://www.schema.org","@type":"Organization","name":"","url":"www.foo.bar","logo":[],"sameAs":[]}</script>',
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    "",
                    "",
                    ["url" => "www.foo.bar"],
                    "",
                    []
                ),
                "expected" => '<script type="application/ld+json">{"@context":"https://www.schema.org","@type":"Organization","name":"","url":"","logo":{"@type":"ImageObject","url":"www.foo.bar","width":0,"height":0},"sameAs":[]}</script>',
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    "",
                    "",
                    [],
                    "facebook",
                    ["facebook" => ["url" => "www.foo.bar"]]
                ),
                "expected" => '<script type="application/ld+json">{"@context":"https://www.schema.org","@type":"Organization","name":"","url":"","logo":[],"sameAs":["www.foo.bar"]}</script>',
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    "",
                    "",
                    [],
                    "facebook,twitter",
                    ["facebook" => ["url" => "www.facebook.com"], "twitter" => ["url" => "www.twitter.com"]]
                ),
                "expected" => '<script type="application/ld+json">{"@context":"https://www.schema.org","@type":"Organization","name":"","url":"","logo":[],"sameAs":["www.facebook.com","www.twitter.com"]}</script>',
            ],
        ];
    }
}