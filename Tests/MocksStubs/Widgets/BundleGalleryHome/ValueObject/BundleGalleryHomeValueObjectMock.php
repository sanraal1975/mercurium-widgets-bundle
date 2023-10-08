<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleGalleryHome\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\ValueObject\BundleGalleryHomeValueObject;

/**
 * Class BundleGalleryHomeValueObjectMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleGalleryHome\ValueObject
 */
class BundleGalleryHomeValueObjectMock extends BundleGalleryHomeValueObject
{
    /**
     * @var Client
     */
    private $api;

    /**
     * @var int
     */
    private $galleryId;

    /**
     * @var EntityNormalizer|null
     */
    private $galleryNormalizer;

    /**
     * @var EntityNormalizer|null
     */
    private $galleryAssetNormalizer;

    /**
     * @var int
     */
    private $assetsQuantity;

    /**
     * @param Client $api
     * @param int $galleryId
     * @param EntityNormalizer|null $galleryNormalizer
     * @param EntityNormalizer|null $galleryAssetNormalizer
     * @param int $assetsQuantity
     */
    public function __construct(
        Client           $api,
        int              $galleryId,
        EntityNormalizer $galleryNormalizer = null,
        EntityNormalizer $galleryAssetNormalizer = null,
        int              $assetsQuantity = PHP_INT_MAX
    )
    {
        $this->api = $api;
        $this->galleryId = $galleryId;
        $this->galleryNormalizer = $galleryNormalizer;
        $this->galleryAssetNormalizer = $galleryAssetNormalizer;
        $this->assetsQuantity = $assetsQuantity;
    }

    /**
     * @return Client
     */
    public function getApi(): Client
    {
        return $this->api;
    }

    /**
     * @return int
     */
    public function getGalleryId(): int
    {
        return $this->galleryId;
    }

    /**
     * @return EntityNormalizer|null
     */
    public function getGalleryNormalizer(): ?EntityNormalizer
    {
        return $this->galleryNormalizer;
    }

    /**
     * @return EntityNormalizer|null
     */
    public function getGalleryAssetNormalizer(): ?EntityNormalizer
    {
        return $this->galleryAssetNormalizer;
    }

    /**
     * @return int
     */
    public function getAssetsQuantity(): int
    {
        return $this->assetsQuantity;
    }
}