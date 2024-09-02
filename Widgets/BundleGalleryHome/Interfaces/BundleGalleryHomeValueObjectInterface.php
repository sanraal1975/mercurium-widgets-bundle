<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Interfaces;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;

/**
 * Interface BundleGalleryHomeValueObjectInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Interfaces
 */
interface BundleGalleryHomeValueObjectInterface
{
    /**
     * @return Client
     */
    public function getApi(): Client;

    /**
     * @return int
     */
    public function getGalleryId(): int;

    /**
     * @return EntityNormalizer
     */
    public function getNormalizer(): EntityNormalizer;
}