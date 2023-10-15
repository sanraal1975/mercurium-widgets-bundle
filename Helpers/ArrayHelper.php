<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers;

/**
 * Class ArrayHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers
 */
class ArrayHelper
{
    /**
     * @param array $items
     * @param string $field
     *
     * @return array
     */
    public function getItemsFieldValue(array $items, string $field): array
    {
        if (empty($items)) {
            return [];
        }

        if (empty($field)) {
            return [];
        }

        return array_map(
            function ($value) use ($field) {
                $result = null;
                if (!empty($value[$field])) {
                    $result = $value[$field];
                }
                return $result;
            },
            $items
        );
    }
}