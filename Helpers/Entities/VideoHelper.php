<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

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
            "limit" => 1,
            "sort" => "publishedAt desc",
            "type" => "video",
        ];

        $image = $this->getBy(
            $options
        );

        return ApiResultsHelper::extractOne($image);
    }
}