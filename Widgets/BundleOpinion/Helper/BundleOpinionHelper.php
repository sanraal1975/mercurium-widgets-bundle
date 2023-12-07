<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\Helper;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ImageHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\ValueObject\BundleOpinionValueObject;
use Exception;

/**
 * Class BundleOpinionHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleOpinion\Helper
 */
class BundleOpinionHelper
{
    /**
     * @var BundleOpinionValueObject
     */
    private $valueObject;

    /**
     * @param BundleOpinionValueObject $valueObject
     */
    public function __construct(BundleOpinionValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getSponsorImage(): array
    {
        $imageId = $this->valueObject->getSponsorImageId();

        if (empty($imageId)) {
            return [];
        }
        $api = $this->valueObject->getApi();
        $imageHelper = new ImageHelper($api);

        return $imageHelper->get($imageId);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getManualArticles(): array
    {
        $api = $this->valueObject->getApi();
        $helper = new ArticleHelper($api);

        return $helper->getByIds($this->valueObject->getArticlesIds());
    }
}