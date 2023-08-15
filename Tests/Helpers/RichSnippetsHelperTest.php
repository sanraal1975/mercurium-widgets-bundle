<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Helpers\RichSnippetsHelper;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class RichSnippetsHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers
 */
class RichSnippetsHelperTest extends TestCase
{
    /**
     * @return void
     */
    public function testWrapThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new RichSnippetsHelper();
        $helper->wrap();
    }

    /**
     * @return void
     */
    public function testWrapThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new RichSnippetsHelper();
        $helper->wrap(null);
    }

    /**
     * @return void
     */
    public function testWrapReturnsEmpty()
    {
        $helper = new RichSnippetsHelper();
        $result = $helper->wrap([]);

        $this->assertEmpty($result);
    }

    /**
     * @return void
     */
    public function testWrapReturnsJson()
    {
        $helper = new RichSnippetsHelper();
        $data = ["url" => "www.foo.bar"];

        $result = $helper->wrap($data);

        $expected = '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES) . "</script>";

        $this->assertEquals($expected, $result);
    }
}