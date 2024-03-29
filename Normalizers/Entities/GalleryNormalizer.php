<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Normalizer\NormalizerInterface;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\EntityHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ImageHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAssetNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityImageNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Exception;

/**
 * Class GalleryNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers\Entities
 */
class GalleryNormalizer implements NormalizerInterface
{
    const QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO = "GalleryNormalizer. quantity of assets to normalize must be equal or greater than 0";

    /**
     * @var Client
     */
    private $api;

    /**
     * @var EntityNormalizer
     */
    private $galleryNormalizer;

    /**
     * @var EntityNormalizer
     */
    private $galleryAssetNormalizer;

    /**
     * @var int
     */
    private $quantityOfAssetsToNormalize;

    /**
     * @param Client $api
     * @param EntityNormalizer|null $galleryNormalizer
     * @param EntityNormalizer|null $galleryAssetNormalizer
     * @param int $quantityOfAssetsToNormalize
     * @throws Exception
     */
    public function __construct(Client $api, EntityNormalizer $galleryNormalizer = null, EntityNormalizer $galleryAssetNormalizer = null, int $quantityOfAssetsToNormalize = PHP_INT_MAX)
    {
        $this->api = $api;
        $this->galleryNormalizer = $galleryNormalizer;
        $this->galleryAssetNormalizer = $galleryAssetNormalizer;
        $this->quantityOfAssetsToNormalize = $quantityOfAssetsToNormalize;

        $this->validate();
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    private function validate()
    {
        if ($this->quantityOfAssetsToNormalize < 0) {
            throw new Exception(self::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);
        }
    }

    /**
     * @param array $entity
     *
     * @return array
     * @throws Exception
     */
    public function normalize(array &$entity): array
    {
        if (!empty($entity)) {
            if ($this->galleryNormalizer != null) {
                $entity = $this->galleryNormalizer->normalize($entity);
            }
            $entity[EntityConstants::TOTAL_ASSETS_FIELD_KEY] = 0;

            if (!empty($entity[EntityConstants::ASSETS_FIELD_KEY])) {
                $entity[EntityConstants::TOTAL_ASSETS_FIELD_KEY] = count($entity[EntityConstants::ASSETS_FIELD_KEY]);
                if ($this->quantityOfAssetsToNormalize > 0) {
                    $normalizedAssets = [];
                    $assetsCount = 0;
                    $assetNormalizer = new EntityImageNormalizer($this->api, EntityConstants::ASSET_FIELD_KEY);
                    $entityHelper = new EntityHelper();

                    foreach ($entity[EntityConstants::ASSETS_FIELD_KEY] as $asset) {
                        $normalizedAsset = $assetNormalizer->normalize([EntityConstants::ASSET_FIELD_KEY => $asset]);
                        $normalizedAsset = $normalizedAsset[EntityConstants::ASSET_FIELD_KEY];

                        if (!$entityHelper->isValid($normalizedAsset)) {
                            continue;
                        }

                        if ($this->galleryAssetNormalizer != null) {
                            $normalizedAsset = $this->galleryAssetNormalizer->normalize($normalizedAsset);
                        }

                        $normalizedAssets[] = $normalizedAsset;

                        $assetsCount++;
                        if ($assetsCount >= $this->quantityOfAssetsToNormalize) {
                            break;
                        }
                    }
                    $entity[EntityConstants::ASSETS_FIELD_KEY] = $normalizedAssets;
                }
            }
        }

        return $entity;
    }
}