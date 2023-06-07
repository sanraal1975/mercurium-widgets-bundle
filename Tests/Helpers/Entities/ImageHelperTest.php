<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ImageHelper;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class ImageHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class ImageHelperTest extends TestCase
{
    /**
     * @dataProvider hasCropReturnFalse
     *
     * @param array $image
     * @param array $crop
     *
     * @return void
     * @throws Exception
     */
    public function testHasCropReturnFalse(array $image, array $crop)
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ImageHelper($api);
        $result = $helper->hasCrop($image, $crop);

        $this->assertFalse($result);
    }

    /**
     * @return array
     */
    public function hasCropReturnFalse(): array
    {
        /*
         * 0 -> empty image
         * 1 -> image without children key
         * 2 -> empty crop
         * 3 -> image don't have child matching crop
         * 4 -> image don't have enough children to match crop
        */

        return [
            [
                "image" => [],
                "crop" => [],
            ],
            [
                "image" => ["id" => 1],
                "crop" => [],
            ],
            [
                "image" => ["children" => []],
                "crop" => [],
            ],
            [
                "image" => ["children" => [0 => ['metadata' => ['width' => 100, 'height' => 100]]]],
                "crop" => [0 => "99|99"],
            ],
            [
                "image" => ["children" => [0 => ['metadata' => ['width' => 100, 'height' => 100]]]],
                "crop" => [0 => "99|99", 1 => "100|100"],
            ]
        ];
    }

    /**
     * @dataProvider hasCropReturnTrue
     *
     * @param array $image
     * @param array $crop
     *
     * @return void
     * @throws Exception
     */
    public function testHasCropReturnTrue(array $image, array $crop)
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ImageHelper($api);
        $result = $helper->hasCrop($image, $crop);

        $this->assertTrue($result);
    }

    /**
     * @return array
     */
    public function hasCropReturnTrue(): array
    {
        /*
         * 0 -> image with one child matching single crop
         * 1 -> image with children and matching single crop
         * 2 -> image with children and matching multiple crop
        */

        return [
            [
                "image" => ["children" => [0 => ['metadata' => ['width' => 100, 'height' => 100]]]],
                "crop" => [0 => "100|100"]
            ],
            [
                "image" => ["children" => [0 => ['metadata' => ['width' => 100, 'height' => 100]], 1 => ['metadata' => ['width' => 99, 'height' => 99]]]],
                "crop" => [0 => "100|100"]
            ],
            [
                "image" => ["children" => [0 => ['metadata' => ['width' => 100, 'height' => 100]], 1 => ['metadata' => ['width' => 99, 'height' => 99]]]],
                "crop" => [0 => "100|100", 1 => "99|99"]
            ]
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testHasCropWrongTypeImageParameter()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new ImageHelper($api);
        $helper->hasCrop(null, []);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testHasCropWrongTypeCropParameter()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new ImageHelper($api);
        $helper->hasCrop([], null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateCropEmptyCropException()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ImageHelper::EMPTY_CROP);

        $helper = new ImageHelper($api);
        $helper->validateCrop("");
    }

    /**
     * @dataProvider validateCropReturnCrop
     *
     * @return void
     * @throws Exception
     */
    public function testValidateCropReturnCrop(string $crop, array $expected)
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ImageHelper($api);
        $result = $helper->validateCrop($crop);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function validateCropReturnCrop(): array
    {
        return [
            [
                "crop" => "100|100",
                "expected" => [100,100]
            ],
            [
                "crop" => "100|100|",
                "expected" => [100,100]
            ],
            [
                "crop" => "100|100|100",
                "expected" => [100,100]
            ],
            [
                "crop" => "100.0|100",
                "expected" => [100,100]
            ],
            [
                "crop" => "100|100.0",
                "expected" => [100,100]
            ],
            [
                "crop" => "100.0|100.0",
                "expected" => [100,100]
            ],
            [
                "crop" => "100.0|100.0|100",
                "expected" => [100,100]
            ],
            [
                "crop" => "100.0|100|100.0",
                "expected" => [100,100]
            ]
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateCropWrongCropExceptionCropWithOneSize()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ImageHelper::WRONG_CROP);

        $helper = new ImageHelper($api);
        $helper->validateCrop("250");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateCropWrongCropExceptionCropWithPipeline()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ImageHelper::WRONG_CROP);

        $helper = new ImageHelper($api);
        $helper->validateCrop("|");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateCropWrongCropExceptionCropWithOneSizeAndPipeline()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ImageHelper::WRONG_CROP);

        $helper = new ImageHelper($api);
        $helper->validateCrop("250|");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateCropWrongCropExceptionCropWithPipelineAndOneSize()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ImageHelper::WRONG_CROP);

        $helper = new ImageHelper($api);
        $helper->validateCrop("|250");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateCropNonNumericCropExceptionFirstValueString()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ImageHelper::NON_NUMERIC_CROP);

        $helper = new ImageHelper($api);
        $helper->validateCrop("a|250");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateCropNonNumericCropExceptionSecondValueString()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ImageHelper::NON_NUMERIC_CROP);

        $helper = new ImageHelper($api);
        $helper->validateCrop("250|a");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateCropNonNumericCropExceptionBothValuesString()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectExceptionMessage(ImageHelper::NON_NUMERIC_CROP);

        $helper = new ImageHelper($api);
        $helper->validateCrop("a|a");
    }
}