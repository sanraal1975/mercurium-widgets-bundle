<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use Exception;

/**
 * Class VideoHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class VideoHelper extends AssetHelper
{
    /**
     * @return array
     * @throws Exception
     */
    public function getLast(): array
    {
        $options = [
            BundleConstants::LIMIT_FIELD_KEY => 1,
            BundleConstants::SORT_FIELD_KEY => BundleConstants::PUBLISHED_DESC,
            BundleConstants::TYPE_FIELD_KEY => "video",
        ];

        $image = $this->getBy(
            $options
        );

        return ApiResultsHelper::extractOne($image);
    }
}