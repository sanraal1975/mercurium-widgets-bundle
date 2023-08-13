<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers;

/**
 * Class RichSnippetsHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class RichSnippetsHelper
{
    /**
     * @param array $data
     *
     * @return string
     */
    public function wrap(array $data): string
    {
        if (empty($data)) {
            return '';
        }

        return '<script type="application/ld+json">' . json_encode($data, JSON_UNESCAPED_SLASHES) . '</script>';
    }
}