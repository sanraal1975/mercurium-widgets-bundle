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
class RichSnippetsFreeAuthorTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetSchemaThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new RichSnippetFreeAuthor();
        $result = $helper->GetSchema();
    }

    /**
     * @return void
     */
    public function testGetSchemaThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new RichSnippetFreeAuthor();
        $result = $helper->GetSchema(null);
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
        $helper = new RichSnippetFreeAuthor();
        $result = $helper->getSchema($authorNames);

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
        $helper = new RichSnippetFreeAuthor();
        $result = $helper->getSchema($authorNames);
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