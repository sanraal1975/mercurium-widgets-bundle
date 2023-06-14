<?php

namespace Comitium5\MercuriumWidgetsBundle\ValueObjects;

use Exception;

/**
 * Class CropsValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\ValueObjects
 */
class CropsValueObject
{
    const EMPTY_CROPS = "CropsValueObject::validate. Crops array can not be empty";

    /**
     * @var CropValueObject[];
     */
    private $crops;

    /**
     * @param array $sizes
     * @throws Exception
     */
    public function __construct(array $sizes)
    {
        $this->validate($sizes);
    }

    /**
     * @return void
     * @throws Exception
     */
    private function validate(array $sizes)
    {
        if (empty($sizes)) {
            throw new Exception(self::EMPTY_CROPS);
        }

        $crops = [];
        foreach ($sizes as $crop) {
            $crops[] = new CropValueObject($crop);
        }

        $this->crops = $crops;
    }

    /**
     * @return CropValueObject[]
     */
    public function getCrops(): array
    {
        return $this->crops;
    }
}