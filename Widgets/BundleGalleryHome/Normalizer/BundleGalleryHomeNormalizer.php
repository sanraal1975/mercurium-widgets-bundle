<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Normalizer;

use Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Interfaces\BundleGalleryHomeValueObjectInterface;
use Exception;

/**
 * Class BundleGalleryHomeNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Normalizer
 */
class BundleGalleryHomeNormalizer
{
    /**
     * @var BundleGalleryHomeValueObjectInterface
     */
    private $valueObject;

    /**
     * @param BundleGalleryHomeValueObjectInterface $valueObject
     */
    public function __construct(BundleGalleryHomeValueObjectInterface $valueObject)
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