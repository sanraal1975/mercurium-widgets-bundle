<?php

namespace Comitium5\MercuriumWidgetsBundle\ValueObjects;

use Exception;

/**
 * Class CropValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\ValueObjects
 */
class CropValueObject
{
    const NON_NUMERIC_CROP = "CropValueObject::validate. Crop with non numeric values.";
    const WRONG_CROP = "CropValueObject::validate. Wrong crop definition.";
    const EMPTY_CROP = "CropValueObject::validate. Crop can not be empty";

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @param string $crop
     * @throws Exception
     */
    public function __construct(string $crop)
    {
        $this->validate($crop);
    }

    /**
     * @return void
     * @throws Exception
     */
    private function validate(string $crop)
    {
        if (empty($crop)) {
            throw new Exception(self::EMPTY_CROP);
        }

        $size = explode("|", $crop);
        if (count($size) < 2) {
            throw new Exception(self::WRONG_CROP . ": " . $crop);
        }

        if (empty($size[0]) || empty($size[1])) {
            throw new Exception(self::WRONG_CROP . ": " . $crop);
        }

        if (!is_numeric($size[0]) || !is_numeric($size[1])) {
            throw new Exception(self::NON_NUMERIC_CROP . ": " . $crop);
        }

        $this->width = (int)$size[0];
        $this->height = (int)$size[1];
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }
}