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
    const WRONG_CROP_FOUND = "ImageHelper::hasCrop. Found wrong crop definition in array crop";

    /**
     * @return array
     * @throws Exception
     */
    public function getLast(): array
    {
        $options = [
            "limit" => 1,
            "sort" => "publishedAt desc",
            "type" => "video",
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
                $size = explode("|", $size);
                if (count($size) < 2) {
                    throw new Exception(self::WRONG_CROP_FOUND);
                }
                if ($child['metadata']['width'] == $size[0] && $child['metadata']['height'] == $size[1]) {
                    $sizesFound++;
                }
            }
        }

        return $sizesFound == $totalResizes;
    }
}