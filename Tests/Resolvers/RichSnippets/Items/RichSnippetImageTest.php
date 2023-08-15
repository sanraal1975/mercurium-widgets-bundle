<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\RichSnippetsConstants;
use Comitium5\MercuriumWidgetsBundle\Factories\RichSnippetsFactory;
use Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items\RichSnippetImage;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\RichSnippetPublisherValueObject;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class RichSnippetImageTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items
 */
class RichSnippetImageTest extends TestCase
{
    /**
     * @var RichSnippetPublisherValueObject
     */
    private $richSnippetPublisherValueObject;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $factory = new RichSnippetsFactory();
        $this->richSnippetPublisherValueObject = $factory->createRichSnippetPublisherValueObject("", "", [], "", []);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetSchemaThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $richSnippetImage = new RichSnippetImage($this->richSnippetPublisherValueObject);
        $result = $richSnippetImage->getSchema();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetSchemaThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $richSnippetImage = new RichSnippetImage($this->richSnippetPublisherValueObject);
        $result = $richSnippetImage->getSchema(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetSchemaReturnEmpty()
    {
        $richSnippetImage = new RichSnippetImage($this->richSnippetPublisherValueObject);
        $result = $richSnippetImage->getSchema([]);
        $this->assertEmpty($result);
    }

    /**
     * @dataProvider getSchemaReturnValue
     *
     * @param $entity
     * @param $expected
     *
     * @return void
     * @throws Exception
     */
    public function testGetSchemaReturnValue($entity, $expected)
    {
        $richSnippetImage = new RichSnippetImage($this->richSnippetPublisherValueObject);
        $result = $richSnippetImage->getSchema($entity);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getSchemaReturnValue(): array
    {
        return [
            [
                "entity" => ["id" => 1],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_IMAGE,
                    "url" => "",
                    "width" => 0,
                    "height" => 0
                ]
            ],
            [
                "entity" => [
                    "id" => 1,
                    "url" => "foo.bar"
                ],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_IMAGE,
                    "url" => "foo.bar",
                    "width" => 0,
                    "height" => 0
                ]
            ],
            [
                "entity" => [
                    "id" => 1,
                    "url" => "foo.bar",
                    "metadata" => [
                        "width" => 1
                    ],
                ],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_IMAGE,
                    "url" => "foo.bar",
                    "width" => 1,
                    "height" => 0
                ]
            ],
            [
                "entity" => [
                    "id" => 1,
                    "url" => "foo.bar",
                    "metadata" => [
                        "width" => 1,
                        "height" => 1
                    ],
                ],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_IMAGE,
                    "url" => "foo.bar",
                    "width" => 1,
                    "height" => 1
                ]
            ],
            [
                "entity" => [
                    "id" => 1,
                    "url" => "foo.bar",
                    "metadata" => [
                        "width" => 1,
                        "height" => 1
                    ],
                    "mimeType" => "image"
                ],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_IMAGE,
                    "url" => "foo.bar",
                    "width" => 1,
                    "height" => 1,
                    "encodingFormat" => "image"
                ]
            ],
            [
                "entity" => [
                    "id" => 1,
                    "url" => "foo.bar",
                    "metadata" => [
                        "width" => 1,
                        "height" => 1
                    ],
                    "mimeType" => "image",
                    "title" => "title"
                ],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_IMAGE,
                    "url" => "foo.bar",
                    "width" => 1,
                    "height" => 1,
                    "encodingFormat" => "image",
                    "name" => "title"
                ]
            ],
            [
                "entity" => [
                    "id" => 1,
                    "url" => "foo.bar",
                    "metadata" => [
                        "width" => 1,
                        "height" => 1
                    ],
                    "mimeType" => "image",
                    "title" => "title",
                    "description" => "description"
                ],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_IMAGE,
                    "url" => "foo.bar",
                    "width" => 1,
                    "height" => 1,
                    "encodingFormat" => "image",
                    "name" => "title",
                    "description" => "description"
                ]
            ],
            [
                "entity" => [
                    "id" => 1,
                    "url" => "foo.bar",
                    "metadata" => [
                        "width" => 1,
                        "height" => 1
                    ],
                    "mimeType" => "image",
                    "title" => "title",
                    "description" => "<p>description</p>"
                ],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_IMAGE,
                    "url" => "foo.bar",
                    "width" => 1,
                    "height" => 1,
                    "encodingFormat" => "image",
                    "name" => "title",
                    "description" => "description"
                ]
            ],
            [
                "entity" => [
                    "id" => 1,
                    "url" => "foo.bar",
                    "metadata" => [
                        "width" => 1,
                        "height" => 1
                    ],
                    "mimeType" => "image",
                    "title" => "title",
                    "description" => "<p>description</p>",
                    "author" => [
                        "permalink" => "www.foo.bar",
                        "fullName" => "Foo Bar",
                    ]
                ],
                "expected" => [
                    "@type" => RichSnippetsConstants::TYPE_IMAGE,
                    "url" => "foo.bar",
                    "width" => 1,
                    "height" => 1,
                    "encodingFormat" => "image",
                    "name" => "title",
                    "description" => "description",
                    "author" => [
                        "@type" => RichSnippetsConstants::TYPE_PERSON,
                        "name" => "Foo Bar",
                        "url" => "www.foo.bar",
                        "affiliation" => [
                            "@type" => RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION,
                            "name" => "",
                            "url" => "",
                            "logo" => [],
                            "sameAs" => []
                        ]
                    ],
                ]
            ],
        ];
    }
}