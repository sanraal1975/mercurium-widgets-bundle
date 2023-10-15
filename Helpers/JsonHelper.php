<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers;

use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;

/**
 * Class JsonHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers
 */
class JsonHelper
{
    /**
     * @param string $jsonContent
     * @param string $locale
     *
     * @return array|mixed
     */
    public function getLocaleIds(string $jsonContent, string $locale)
    {
        $helper = new TestHelper();

        if (empty($jsonContent)) {
            return [];
        }

        if (empty($locale)) {
            return [];
        }

        $result = [];

        $decodedContent = json_decode($jsonContent, true);
        if (!empty($decodedContent[$locale])) {
            $result = $decodedContent[$locale];
        }

        return $result;
    }
}