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