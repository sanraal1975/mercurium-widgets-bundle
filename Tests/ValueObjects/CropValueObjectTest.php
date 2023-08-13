<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\ValueObjects;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\CropValueObject;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class CropValueObjectTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\ValueObjects
 */
class CropValueObjectTest extends TestCase
{
    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        new CropValueObject();
    }
    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        new CropValueObject(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageEmptyCrop()
    {
        $this->expectExceptionMessage(CropValueObject::EMPTY_CROP);

        new CropValueObject("");
    }

    /**
     * @dataProvider validateThrowsExceptionMessageWrongCrop
     *
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageWrongCrop($crop)
    {
        $this->expectExceptionMessage(CropValueObject::WRONG_CROP);

        new CropValueObject($crop);
    }

    /**
     *
     * @return array[]
     */
    public function validateThrowsExceptionMessageWrongCrop(): array
    {
        return [
            [
                "crop" => "250"
            ],
            [
                "crop" => "250|"
            ],
            [
                "crop" => "|250"
            ]
        ];
    }

    /**
     * @dataProvider validateThrowsExceptionMessageNonNumericCrop
     *
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsExceptionMessageNonNumericCrop($crop)
    {
        $this->expectExceptionMessage(CropValueObject::NON_NUMERIC_CROP);

        new CropValueObject($crop);
    }

    /**
     * @return array[]
     */
    public function validateThrowsExceptionMessageNonNumericCrop()
    {
        return [
            [
                "crop" => "a|250"
            ],
            [
                "crop" => "250|a"
            ],
            [
                "crop" => "a|a"
            ],
        ];
    }

    /**
     * @dataProvider validateCropReturnCrop
     * 
     * @param string $crop
     * @param array $expected
     *
     * @return void
     * @throws Exception
     */
    public function testValidateReturnCrop(string $crop, array $expected)
    {
        $valueObject = new CropValueObject($crop);

        $result = ["width" => $valueObject->getWidth(), "height" => $valueObject->getHeight()];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function validateCropReturnCrop(): array
    {
        return [
            [
                "crop" => "100|100",
                "expected" => ["width" => 100, "height" => 100]
            ],
            [
                "crop" => "100|100|",
                "expected" => ["width" => 100, "height" => 100]
            ],
            [
                "crop" => "100|100|100",
                "expected" => ["width" => 100, "height" => 100]
            ],
            [
                "crop" => "100.0|100",
                "expected" => ["width" => 100, "height" => 100]
            ],
            [
                "crop" => "100|100.0",
                "expected" => ["width" => 100, "height" => 100]
            ],
            [
                "crop" => "100.0|100.0",
                "expected" => ["width" => 100, "height" => 100]
            ],
            [
                "crop" => "100.0|100.0|100",
                "expected" => ["width" => 100, "height" => 100]
            ],
            [
                "crop" => "100.0|100|100.0",
                "expected" => ["width" => 100, "height" => 100]
            ]
        ];
    }
}