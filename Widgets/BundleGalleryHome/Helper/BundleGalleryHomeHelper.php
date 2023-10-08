<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Helper;

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
     */
    public function __construct(BundleGalleryHomeValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getGallery()
    {
        $galleryId = $this->valueObject->getGalleryId();
        $api = $this->valueObject->getApi();

        $helper = new GalleryHelper($api);

        return $helper->get($galleryId);
    }
}