<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Constants\RichSnippetsConstants;
use Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items\RichSnippetFreeAuthor;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class RichSnippetsFreeAuthorTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items
 */
class RichSnippetFreeAuthorTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetSchemaThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $richSnippetFreeAuthor = new RichSnippetFreeAuthor();
        $result = $richSnippetFreeAuthor->GetSchema();
    }

    /**
     * @return void
     */
    public function testGetSchemaThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $richSnippetFreeAuthor = new RichSnippetFreeAuthor();
        $result = $richSnippetFreeAuthor->GetSchema(null);
    }

    /**
     * @dataProvider getSchemaReturnsEmpty
     *
     * @param $authorNames
     * @param $expected
     *
     * @return void
     */
    public function testGetSchemaReturnsEmpty($authorNames, $expected)
    {
        $richSnippetFreeAuthor = new RichSnippetFreeAuthor();
        $result = $richSnippetFreeAuthor->getSchema($authorNames);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getSchemaReturnsEmpty(): array
    {
        return [
            [
                "authorNames" => "",
                "expected" => []
            ],
            [
                "authorNames" => ",",
                "expected" => []
            ],
        ];
    }

    /**
     * @dataProvider getSchemaReturnsValue
     *
     * @return void
     */
    public function testGetSchemaReturnsValue($authorNames, $expected)
    {
        $richSnippetFreeAuthor = new RichSnippetFreeAuthor();
        $result = $richSnippetFreeAuthor->getSchema($authorNames);
        $this->assertEquals($expected, $result);
    }

    /**
     *
     * @return array[]
     */
    public function getSchemaReturnsValue(): array
    {
        return [
            [
                "authorNames" => "author1",
                "expected" => [
                    [
                        "@type" => RichSnippetsConstants::TYPE_PERSON,
                        "name" => "author1"
                    ]
                ]
            ],
            [
                "authorNames" => "author1,",
                "expected" => [
                    [
                        "@type" => RichSnippetsConstants::TYPE_PERSON,
                        "name" => "author1"
                    ]
                ]
            ],
            [
                "authorNames" => "author1,author2",
                "expected" => [
                    [
                        "@type" => RichSnippetsConstants::TYPE_PERSON,
                        "name" => "author1"
                    ],
                    [
                        "@type" => RichSnippetsConstants::TYPE_PERSON,
                        "name" => "author2"
                    ]
                ]
            ],
        ];
    }
}