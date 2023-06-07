<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\CropsValueObject;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\CropValueObject;
use Exception;

/**
 * Class ImageHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class ImageHelper extends AssetHelper
{
    /**
     * @return array
     * @throws Exception
     */
    public function getLast(): array
    {
        $options = [
            "limit" => 1,
            "sort" => "publishedAt desc",
            "type" => "image",
        ];

        $image = $this->getBy(
            $options
        );

        return ApiResultsHelper::extractOne($image);
    }

    /**
     * @param array $image
     * @param CropsValueObject $cropsValueObject
     *
     * @return bool
     * @throws Exception
     */
    public function hasCrop(array $image, CropsValueObject $cropsValueObject): bool
    {
        if (empty($image)) {
            return false;
        }

        if (empty($image['children'])) {
            return false;
        }

        $crops = $cropsValueObject->getCrops();

        $totalResizes = count($crops);
        $sizesFound = 0;

        foreach ($image['children'] as $child) {
            foreach ($crops as $crop) {
                if ($child['metadata']['width'] == $crop->getWidth() && $child['metadata']['height'] == $crop->getHeight()) {
                    $sizesFound++;
                }
            }
        }

        return $sizesFound == $totalResizes;
    }

    /**
     * @param array $image
     * @param CropValueObject $crop
     *
     * @return array
     */
    public function setCrop(array $image, CropValueObject $crop): array
    {
        if (empty($image)) {
            return $image;
        }

        if (empty($image['children'])) {
            return $image;
        }

        foreach ($image['children'] as $child) {
            if ($child['metadata']['width'] == $crop->getWidth() && $child['metadata']['height'] == $crop->getHeight()) {
                $image['url'] = $child['url'];
                $image['metadata']['width'] = $child['metadata']['width'];
                $image['metadata']['height'] = $child['metadata']['height'];
                break;
            }
        }

        return $image;
    }
}