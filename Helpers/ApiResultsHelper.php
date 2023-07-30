<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers;

/**
 * Class ApiResultsHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers
 */
class ApiResultsHelper
{
    /**
     * @param array $apiResponse
     * @param int $position
     * @param string $key
     *
     * @return array
     */
    public static function extractOne(
        array  $apiResponse,
        int    $position = 0,
        string $key = "results"
    ): array
    {
        return $apiResponse[$key][$position] ?? [];
    }

    /**
     * @param array $apiResponse
     * @param string $key
     *
     * @return array
     */
    public static function extractResults(
        array  $apiResponse,
        string $key = "results"
    ): array
    {
        return !empty($apiResponse[$key]) ? $apiResponse[$key] : [];
    }
}