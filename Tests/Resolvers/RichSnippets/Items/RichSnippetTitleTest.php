<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items\RichSnippetTitle;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class RichSnippetTitleTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Resolvers\RichSnippets\Items
 */
class RichSnippetTitleTest extends TestCase
{
    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new RichSnippetTitle();
        $result = $helper->getTitle();
    }

    /**
     * @return void
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new RichSnippetTitle();
        $result = $helper->getTitle("hello world");
    }

    /**
     * @dataProvider getTitleReturnsEmpty
     *
     * @param $entity
     * @param $expected
     *
     * @return void
     */
    public function testGetTitleReturnsEmpty($entity, $expected)
    {
        $helper = new RichSnippetTitle();
        $result = $helper->getTitle($entity);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getTitleReturnsEmpty(): array
    {
        return [
            [
                "entity" => ["id" => 1],
                "expected" => ""
            ],
            [
                "entity" => ["id" => 1, "title" => " "],
                "expected" => ""
            ],
        ];
    }

    /**
     * @return void
     */
    public function testGetTitleReturnsTitle()
    {
        $helper = new RichSnippetTitle();
        $title = "dummy title";
        $expected = $title;
        $entity = ["title" => $title];
        $result = $helper->getTitle($entity);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     */
    public function testGetTitleReturnsTitleCut()
    {
        $helper = new RichSnippetTitle();
        $title = "this is a long dummy title";
        $expected = "this is...";
        $entity = ["title" => $title];
        $result = $helper->getTitle($entity, $helper::DEFAULT_FIELD_NAME, 10);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     */
    public function testGetTitleReturnsTitleCutWithCustomEnd()
    {
        $helper = new RichSnippetTitle();
        $title = "this is a long dummy title";
        $expected = "this is....";
        $entity = ["title" => $title];
        $result = $helper->getTitle($entity, $helper::DEFAULT_FIELD_NAME, 11,"....");
        $this->assertEquals($expected, $result);
    }
}