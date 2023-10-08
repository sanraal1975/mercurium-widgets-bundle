<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Helper;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\EntityHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\GalleryHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\ValueObject\BundleGalleryHomeValueObject;
use Exception;

/**
 * Class BundleGalleryHomeHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Helper
 */
class BundleGalleryHomeHelper
{
    /**
     * @var BundleGalleryHomeValueObject
     */
    private $valueObject;

    /**
     * @param BundleGalleryHomeValueObject $valueObject
     * @throws Exception
     */
    public function __construct(BundleGalleryHomeValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getGallery(): array
    {
        $gallery = [];
        $galleryId = $this->valueObject->getGalleryId();

        if ($galleryId > 0) {
            $api = $this->valueObject->getApi();

            $galleryHelper = new GalleryHelper($api);
            $gallery = $galleryHelper->get($galleryId);

            $entityHelper = new EntityHelper();
            $gallery = ($entityHelper->isValid($gallery)) ? $gallery : [];
        }

        return $gallery;
    }
}