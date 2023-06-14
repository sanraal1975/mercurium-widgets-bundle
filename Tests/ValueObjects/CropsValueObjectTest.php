<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\ValueObjects;

use Comitium5\MercuriumWidgetsBundle\ValueObjects\CropsValueObject;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\CropValueObject;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class CropsValueObjectTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\ValueObjects
 */
class CropsValueObjectTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testConstructWrongTypeArrayParameter()
    {
        $this->expectException(TypeError::class);

        new CropsValueObject(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateEmptyCropsException()
    {
        $this->expectExceptionMessage(CropsValueObject::EMPTY_CROPS);

        new CropsValueObject([]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateEmptyDefinedCrop()
    {
        $this->expectExceptionMessage(CropValueObject::EMPTY_CROP);

        new CropsValueObject([0 => ""]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateInvalidDefinedCropOneValue()
    {
        $this->expectExceptionMessage(CropValueObject::WRONG_CROP);

        new CropsValueObject([0 => "250"]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateInvalidDefinedCropPipelineWithoutValues()
    {
        $this->expectExceptionMessage(CropValueObject::WRONG_CROP);

        new CropsValueObject([0 => "|"]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateInvalidDefinedCropPipelineWithValueBefore()
    {
        $this->expectExceptionMessage(CropValueObject::WRONG_CROP);

        new CropsValueObject([0 => "250|"]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateInvalidDefinedCropPipelineWithValueAfter()
    {
        $this->expectExceptionMessage(CropValueObject::WRONG_CROP);

        new CropsValueObject([0 => "|250"]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateInvalidDefinedCropPipelineWithNonNumericValues()
    {
        $this->expectExceptionMessage(CropValueObject::NON_NUMERIC_CROP);

        new CropsValueObject([0 => "a|a"]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateInvalidDefinedCropPipelineWithNonNumericValueInFirstPosition()
    {
        $this->expectExceptionMessage(CropValueObject::NON_NUMERIC_CROP);

        new CropsValueObject([0 => "a|250"]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidateInvalidDefinedCropPipelineWithNonNumericValueInSecondPosition()
    {
        $this->expectExceptionMessage(CropValueObject::NON_NUMERIC_CROP);

        new CropsValueObject([0 => "250|a"]);
    }
}