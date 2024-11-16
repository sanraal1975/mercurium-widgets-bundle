<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Helper;

use Comitium5\MercuriumWidgetsBundle\Helpers\WidgetHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Interfaces\BundleGalleryHomeValueObjectInterface;
use Exception;

/**
 * Class BundleGalleryHomeHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleGalleryHome\Helper
 */
class BundleGalleryHomeHelper extends WidgetHelper
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
        $api = $valueObject->getApi();
        parent::__construct($api);

        $this->valueObject = $valueObject;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getGalleryFromApi(): array
    {
        $gallery = [];

        $galleryId = $this->valueObject->getGalleryId();
        if ($galleryId > 0) {
            $gallery = $this->getGallery($galleryId);
        }

        return $gallery;
    }
}