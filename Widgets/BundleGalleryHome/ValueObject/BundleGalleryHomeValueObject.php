<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;

/**
 * Class BundleGalleryHomeValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\ValueObject
 */
abstract class BundleGalleryHomeValueObject
{
    /**
     * @return Client
     */
    abstract public function getApi(): Client;

    /**
     * @return int
     */
    abstract public function getGalleryId(): int;

    /**
     * @return EntityNormalizer|null
     */
    abstract public function getGalleryNormalizer(): ?EntityNormalizer;

    /**
     * @return EntityNormalizer|null
     */
    abstract public function getGalleryAssetNormalizer(): ?EntityNormalizer;

    /**
     * @return int
     */
    abstract public function getAssetsQuantity(): int;

}