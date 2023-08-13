<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items\RichSnippetCanonical;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class RichSnippetCanonicalTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items
 */
class RichSnippetCanonicalTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetCanonicalThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $richSnippetCanonical = new RichSnippetCanonical();
        $result = $richSnippetCanonical->getCanonical();
    }

    /**
     * @return void
     */
    public function testGetCanonicalThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $richSnippetCanonical = new RichSnippetCanonical();
        $result = $richSnippetCanonical->getCanonical("hello world");
    }

    /**
     * @dataProvider getCanonicalReturnsEmpty
     *
     * @param $entity
     * @param $expected
     *
     * @return void
     */
    public function testGetCanonicalReturnsEmpty($entity, $expected)
    {
        $richSnippetCanonical = new RichSnippetCanonical();
        $result = $richSnippetCanonical->getCanonical($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getCanonicalReturnsEmpty(): array
    {
        return [
            [
                "entity" => [],
                "expected" => ""
            ],
            [
                "entity" => ["metadata" => ["canonical" => ""]],
                "expected" => ""
            ],
            [
                "entity" => ["permalink" => ""],
                "expected" => ""
            ],
        ];
    }

    /**
     * @dataProvider getCanonicalReturnsValue
     *
     * @return void
     */
    public function testGetCanonicalReturnsValue($entity, $expected)
    {
        $richSnippetCanonical = new RichSnippetCanonical();
        $result = $richSnippetCanonical->getCanonical($entity);
        $this->assertEquals($expected, $result);
    }

    /**
     *
     * @return array[]
     */
    public function getCanonicalReturnsValue(): array
    {
        return [
            [
                "entity" => ["metadata" => ["canonical" => "canonical"]],
                "expected" => "canonical"
            ],
            [
                "entity" => ["permalink" => "permalink"],
                "expected" => "permalink"
            ],
        ];
    }
}