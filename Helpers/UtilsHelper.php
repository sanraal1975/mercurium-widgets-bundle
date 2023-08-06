<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers;

/**
 * Class UtilsHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers
 */
class UtilsHelper
{
    /**
     * @param string $text
     *
     * @return string
     */
    public function cleanHtmlText(string $text): string
    {
        return strip_tags(trim($text));
    }
}