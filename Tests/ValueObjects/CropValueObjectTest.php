<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\ValueObjects;

use Comitium5\MercuriumWidgetsBundle\ValueObjects\CropValueObject;
use Exception;
use PHPUnit\Framework\TestCase;

class CropValueObjectTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testValidateEmptyCropException()
    {
        $this->expectExceptionMessage(CropValueObject::EMPTY_CROP);

        new CropValueObject("");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateWrongCropExceptionCropWithoutPipeline()
    {
        $this->expectExceptionMessage(CropValueObject::WRONG_CROP);

        new CropValueObject("250");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateWrongCropExceptionCropWithOneValueAndPipeline()
    {
        $this->expectExceptionMessage(CropValueObject::WRONG_CROP);

        new CropValueObject("250|");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateWrongCropExceptionCropWithPipelineAndOneValue()
    {
        $this->expectExceptionMessage(CropValueObject::WRONG_CROP);

        new CropValueObject("|250");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateNonNumericCropExceptionCropWithWrongFirstValue()
    {
        $this->expectExceptionMessage(CropValueObject::NON_NUMERIC_CROP);

        new CropValueObject("a|250");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateNonNumericCropExceptionCropWithWrongSecondValue()
    {
        $this->expectExceptionMessage(CropValueObject::NON_NUMERIC_CROP);

        new CropValueObject("250|a");
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateNonNumericCropExceptionCropWithWrongValues()
    {
        $this->expectExceptionMessage(CropValueObject::NON_NUMERIC_CROP);

        new CropValueObject("a|a");
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