<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ImageHelper;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\CropsValueObject;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\CropValueObject;
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
     * @throws Exception
     */
    public function testHasCropReturnFalse(array $image, CropsValueObject $crops)
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ImageHelper($api);
        $result = $helper->hasCrop($image, $crops);

        $this->assertFalse($result);
    }

    /**
     * @return array[]
     * @throws Exception
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
                "crops" => new CropsValueObject(["100|100"]),
            ],
            [
                "image" => ["id" => 1],
                "crops" => new CropsValueObject(["100|100"]),
            ],
            [
                "image" => ["children" => []],
                "crops" => new CropsValueObject(["100|100"]),
            ],
            [
                "image" => ["children" => [0 => ['metadata' => ['width' => 100, 'height' => 100]]]],
                "crops" => new CropsValueObject(["99|99"]),
            ],
            [
                "image" => ["children" => [0 => ['metadata' => ['width' => 100, 'height' => 100]]]],
                "crops" => new CropsValueObject(["99|99", "100|100"]),
            ],
        ];
    }

    /**
     * @dataProvider hasCropReturnTrue
     *
     * @param array $image
     * @param CropsValueObject $crop
     *
     * @return void
     * @throws Exception
     */
    public function testHasCropReturnTrue(array $image, CropsValueObject $crop)
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ImageHelper($api);
        $result = $helper->hasCrop($image, $crop);

        $this->assertTrue($result);
    }

    /**
     * @return array[]
     * @throws Exception
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
                "crop" => new CropsValueObject(["100|100"])
            ],
            [
                "image" => ["children" => [0 => ['metadata' => ['width' => 100, 'height' => 100]], 1 => ['metadata' => ['width' => 99, 'height' => 99]]]],
                "crop" => new CropsValueObject(["100|100"])
            ],
            [
                "image" => ["children" => [0 => ['metadata' => ['width' => 100, 'height' => 100]], 1 => ['metadata' => ['width' => 99, 'height' => 99]]]],
                "crop" => new CropsValueObject(["100|100", "99|99"])
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
        $helper->hasCrop(null, new CropsValueObject(["100|100"]));
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
    public function testSetCropWrongTypeImageParameter()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new ImageHelper($api);
        $helper->hasCrop(null, new CropsValueObject(["100|100"]));
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testSetCropWrongTypeCropParameter()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $this->expectException(TypeError::class);

        $helper = new ImageHelper($api);
        $helper->hasCrop([], null);
    }

    /**
     * @dataProvider setCropCropNotFound
     *
     * @return void
     * @throws Exception
     */
    public function testSetCropCropNotFound(array $image, CropValueObject $crop, array $expected)
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ImageHelper($api);
        $result = $helper->setCrop($image, $crop);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function setCropCropNotFound(): array
    {
        /*
         * 0 -> empty Image
         * 1 -> image without children
         * 2 -> image with children no matching crop
         */
        return [
            [
                "image" => [],
                "crop" => new CropValueObject("100|100"),
                "expected" => []
            ],
            [
                "image" => ["id" => 1],
                "crop" => new CropValueObject("100|100"),
                "expected" => ["id" => 1]
            ],
            [
                "image" => [
                    "id" => 1,
                    "url" => "https://www.bar.foo",
                    "metadata" => ["width" => 100, "height" => 100],
                    "children" => [
                        0 => [
                            "url" => "https://www.foo.bar",
                            "metadata" => ["width" => 10, "height" => 10]
                        ]
                    ]
                ],
                "crop" => new CropValueObject("100|100"),
                "expected" => [
                    "id" => 1,
                    "url" => "https://www.bar.foo",
                    "metadata" => ["width" => 100, "height" => 100],
                    "children" => [
                        0 => [
                            "url" => "https://www.foo.bar",
                            "metadata" => ["width" => 10, "height" => 10]
                        ]
                    ]
                ],
            ],
        ];
    }


    /**
     * @dataProvider setCropCropNotFound
     *
     * @return void
     * @throws Exception
     */
    public function testSetCropCropFound()
    {
        $api = new Client("https://foo.bar", "fake_token");

        $helper = new ImageHelper($api);

        $image = [
            "id" => 1,
            "url" => "https://www.bar.foo",
            "metadata" => ["width" => 100, "height" => 100],
            "children" => [
                0 => [
                    "url" => "https://www.foo.bar",
                    "metadata" => ["width" => 10, "height" => 10]
                ]
            ]
        ];

        $crop = new CropValueObject("10|10");

        $expected = [
            "id" => 1,
            "url" => "https://www.foo.bar",
            "metadata" => ["width" => 10, "height" => 10],
            "children" => [
                0 => [
                    "url" => "https://www.foo.bar",
                    "metadata" => ["width" => 10, "height" => 10]
                ]
            ]
        ];

        $result = $helper->setCrop($image, $crop);

        $this->assertEquals($expected, $result);
    }
}