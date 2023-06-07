<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use Exception;

/**
 * Class ImageHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class ImageHelper extends AssetHelper
{
    const NON_NUMERIC_CROP = "ImageHelper::validateCrop. Crop with non numeric values.";
    const WRONG_CROP = "ImageHelper::validateCrop. Wrong crop definition.";
    const EMPTY_CROP = "ImageHelper::validateCrop. Crop can not be empty";

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
     * @param array $crop
     *
     * @return bool
     * @throws Exception
     */
    public function hasCrop(array $image, array $crop): bool
    {
        if (empty($image)) {
            return false;
        }

        if (empty($image['children'])) {
            return false;
        }

        if (empty($crop)) {
            return false;
        }

        $totalResizes = count($crop);
        $sizesFound = 0;

        foreach ($image['children'] as $child) {
            foreach ($crop as $size) {
                $size = $this->validateCrop($size);
                if ($child['metadata']['width'] == $size[0] && $child['metadata']['height'] == $size[1]) {
                    $sizesFound++;
                }
            }
        }

        return $sizesFound == $totalResizes;
    }

    /**
     * @param string $crop
     *
     * @return array
     * @throws Exception
     */
    public function validateCrop(string $crop): array
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

        return [(int)$size[0], (int)$size[1]];
    }
}