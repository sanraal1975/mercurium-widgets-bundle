<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers;

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
        if (empty($jsonContent)) {
            return [];
        }

        if (empty($locale)) {
            return [];
        }

        $decodedContent = json_decode($jsonContent, true);

        return (empty($decodedContent[$locale])) ? [] : $decodedContent[$locale];
    }
}