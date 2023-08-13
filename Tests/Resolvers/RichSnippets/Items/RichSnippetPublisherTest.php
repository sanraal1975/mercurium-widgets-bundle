<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items;

use Comitium5\MercuriumWidgetsBundle\Constants\RichSnippetsConstants;
use Comitium5\MercuriumWidgetsBundle\Factories\RichSnippetsFactory;
use Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items\RichSnippetPublisher;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class RichSnippetPublisherTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items
 */
class RichSnippetPublisherTest extends TestCase
{
    /**
     * @dataProvider getSchema
     *
     * @return void
     * @throws Exception
     */
    public function testGetSchema($valueObject, $expected)
    {
        $richSnippet = new RichSnippetPublisher($valueObject);
        $result = $richSnippet->getSchema();

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getSchema(): array
    {
        $factory = new RichSnippetsFactory();

        return [
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    '',
                    '',
                    [],
                    '',
                    []
                ),
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_ORGANIZATION,
                    "name" => '',
                    "url" => '',
                    "logo" => [],
                    "sameAs" => [],
                ]
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    'Foo Bar',
                    '',
                    [],
                    '',
                    []
                ),
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_ORGANIZATION,
                    "name" => 'Foo Bar',
                    "url" => '',
                    "logo" => [],
                    "sameAs" => [],
                ]
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    '',
                    'www.foo.bar',
                    [],
                    '',
                    []
                ),
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_ORGANIZATION,
                    "name" => '',
                    "url" => 'www.foo.bar',
                    "logo" => [],
                    "sameAs" => [],
                ]
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    '',
                    '',
                    ["url" => "www.foo.bar"],
                    '',
                    []
                ),
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_ORGANIZATION,
                    "name" => '',
                    "url" => '',
                    "logo" => [
                        "@type" => RichSnippetsConstants::TYPE_IMAGE,
                        "url" => "www.foo.bar",
                        "width" => 0,
                        "height" => 0
                    ],
                    "sameAs" => [],
                ]
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    '',
                    '',
                    [],
                    '',
                    []
                ),
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_ORGANIZATION,
                    "name" => '',
                    "url" => '',
                    "logo" => [],
                    "sameAs" => [],
                ]
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    '',
                    '',
                    [],
                    'facebook',
                    []
                ),
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_ORGANIZATION,
                    "name" => '',
                    "url" => '',
                    "logo" => [],
                    "sameAs" => [],
                ]
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    '',
                    '',
                    [],
                    'twitter',
                    ["facebook" => ["url" => "www.facebook.com"]]
                ),
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_ORGANIZATION,
                    "name" => '',
                    "url" => '',
                    "logo" => [],
                    "sameAs" => [],
                ]
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    '',
                    '',
                    [],
                    'facebook',
                    ["facebook" => ["url" => "www.facebook.com"]]
                ),
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_ORGANIZATION,
                    "name" => '',
                    "url" => '',
                    "logo" => [],
                    "sameAs" => ["www.facebook.com"],
                ]
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    '',
                    '',
                    [],
                    'facebook,twitter',
                    [
                        "facebook" => ["url" => "www.facebook.com"],
                        "twitter" => ["url" => "www.twitter.com"],
                    ]
                ),
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_ORGANIZATION,
                    "name" => '',
                    "url" => '',
                    "logo" => [],
                    "sameAs" => ["www.facebook.com", "www.twitter.com"],
                ]
            ],
            [
                "valueObject" => $factory->createRichSnippetPublisherValueObject(
                    '',
                    '',
                    [],
                    'facebook,twitter,linkedin',
                    [
                        "facebook" => ["url" => "www.facebook.com"],
                        "twitter" => ["url" => "www.twitter.com"],
                    ]
                ),
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_ORGANIZATION,
                    "name" => '',
                    "url" => '',
                    "logo" => [],
                    "sameAs" => ["www.facebook.com", "www.twitter.com"],
                ]
            ],
        ];
    }
}