<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Normalizer;

use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\GalleryNormalizer;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\ValueObject\BundleGalleryHomeValueObject;
use Exception;

/**
 * Class BundleGalleryHomeNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Normalizer
 */
class BundleGalleryHomeNormalizer
{
    /**
     * @var BundleGalleryHomeValueObject
     */
    private $valueObject;

    /**
     * @param BundleGalleryHomeValueObject $valueObject
     */
    public function __construct(BundleGalleryHomeValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    /**
     * @param array $gallery
     *
     * @return array
     * @throws Exception
     */
    public function normalize(array $gallery): array
    {
        if (empty($gallery)) {
            return [];
        }

        $normalizer = $this->valueObject->getNormalizer();

        return $normalizer->normalize($gallery);
    }
}