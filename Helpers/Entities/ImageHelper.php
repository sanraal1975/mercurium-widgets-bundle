<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use Comitium5\MercuriumWidgetsBundle\Interfaces\EntityGetLastInterface;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\CropsValueObject;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\CropValueObject;
use Exception;

/**
 * Class ImageHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class ImageHelper extends AssetHelper implements EntityGetLastInterface
{
    /**
     * @param int $imageId
     *
     * @return array
     * @throws Exception
     */
    public function get(int $imageId): array
    {
        $image = [];

        if ($imageId > 0) {
            $image = parent::get($imageId);
            if (!empty($image)) {
                $image = $this->setOrientation($image);
            }
        }

        return $image;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getLast(): array
    {
        $options = [
            EntityConstants::LIMIT_FIELD_KEY => 1,
            EntityConstants::SORT_FIELD_KEY => EntityConstants::PUBLISHED_DESC,
            EntityConstants::TYPE_FIELD_KEY => "image",
        ];

        $image = $this->getBy($options);

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

        if (empty($image["children"])) {
            return false;
        }

        $crops = $cropsValueObject->getCrops();

        $totalSizes = count($crops);
        $sizesFound = 0;

        foreach ($crops as $crop) {
            foreach ($image["children"] as $child) {
                if ($child["metadata"]["width"] == $crop->getWidth() && $child["metadata"]["height"] == $crop->getHeight()) {
                    $sizesFound++;
                }
            }
        }

        return $sizesFound == $totalSizes;
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

        if (empty($image["children"])) {
            return $image;
        }

        $width = $crop->getWidth();
        $height = $crop->getHeight();

        foreach ($image["children"] as $child) {
            if ($child["metadata"]["width"] == $width && $child["metadata"]["height"] == $height) {
                $image["url"] = $child["url"];
                $image["metadata"]["width"] = $child["metadata"]["width"];
                $image["metadata"]["height"] = $child["metadata"]["height"];
                break;
            }
        }

        return $image;
    }

    /**
     * @param array $image
     *
     * @return array
     */
    public function setOrientation(array $image): array
    {
        if (empty($image)) {
            return [];
        }

        $width = 0;
        if (!empty($image['metadata']['width'])) {
            $width = $image['metadata']['width'];
        }

        $height = 0;
        if (!empty($image['metadata']['height'])) {
            $height = $image['metadata']['height'];
        }

        if ($height > $width) {
            $image['orientation'] = "is-vertical";
        } elseif ($height < $width) {
            $image['orientation'] = "is-horizontal";
        } else {
            $image['orientation'] = "is-square";
        }

        return $image;
    }
}