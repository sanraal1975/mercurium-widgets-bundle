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
     * @var EntityNormalizer
     */
    private $normalizer;

    /**
     * @param Client $api
     * @param int $galleryId
     * @param EntityNormalizer $normalizer
     */
    public function __construct(
        Client           $api,
        int              $galleryId,
        EntityNormalizer $normalizer
    )
    {
        $this->api = $api;
        $this->galleryId = $galleryId;
        $this->normalizer = $normalizer;
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
     * @return EntityNormalizer
     */
    public function getNormalizer(): EntityNormalizer
    {
        return $this->normalizer;
    }
}