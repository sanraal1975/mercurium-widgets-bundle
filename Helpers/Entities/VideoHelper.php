<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use Comitium5\MercuriumWidgetsBundle\Interfaces\EntityGetLastInterface;
use Exception;

/**
 * Class VideoHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class VideoHelper extends AssetHelper implements EntityGetLastInterface
{
    /**
     * @return array
     * @throws Exception
     */
    public function getLast(): array
    {
        $options = [
            EntityConstants::LIMIT_FIELD_KEY => 1,
            EntityConstants::SORT_FIELD_KEY => EntityConstants::PUBLISHED_DESC,
            EntityConstants::TYPE_FIELD_KEY => "video",
        ];

        $image = $this->getBy($options);

        return ApiResultsHelper::extractOne($image);
    }
}