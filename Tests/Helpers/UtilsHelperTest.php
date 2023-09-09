<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Helpers\UtilsHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class UtilsHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers
 */
class UtilsHelperTest extends TestCase
{
    /**
     * @return void
     */
    public function testCleanHtmlTextThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new UtilsHelper();
        $result = $helper->cleanHtmlText();
    }

    /**
     * @dataProvider cleanHtmlTextReturnsValue
     *
     * @return void
     */
    public function testCleanHtmlTextReturnsValue($input, $expected)
    {
        $helper = new UtilsHelper();
        $result = $helper->cleanHtmlText($input);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function cleanHtmlTextReturnsValue(): array
    {
        return [
            [
                "input" => "",
                "expected" => "",
            ],
            [
                "input" => "<div>dummy_text</div>",
                "expected" => "dummy_text"
            ]
        ];
    }
}