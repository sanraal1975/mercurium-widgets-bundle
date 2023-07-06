<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers;

use Comitium5\ApiClientBundle\Client\Client;

/**
 * Class TestHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers
 */
class TestHelper
{
    const API_ENDPOINT = "https://csmercurium.wearebab.com/api/v2/";
    const API_TOKEN = "YjY1NmQ4NjQ2MmYxOTk4MGJjZjc3YzQ1NWI4MGI3NDViNTJiMjQ2M2JhOWJiZDQ0OTRiMDA2ZTM3NjMwMWY2ZQ";
    const API_SITE = "mercurium";
    const API_SUBSITE = "mercurium";
    const API_LOCALE = "ca";

    const IMAGE_FIELD_KEY = "image";
    const VIDEO_FIELD_KEY = "video";
    const AUTHOR_FIELD_KEY = "author";

    /**
     * @return Client
     */
    public function getApi(): Client
    {
        $client = new Client(self::API_ENDPOINT, self::API_TOKEN);

        return $client->buildClient(self::API_SITE, self::API_SUBSITE, self::API_LOCALE);
    }

    /**
     * @return int
     */
    public function getZeroOrNegativeValue(): int
    {
        return rand(PHP_INT_MIN, 0);
    }

    /**
     * @return string
     */
    public function getZeroOrNegativeValueAsString(): string
    {
        return strval($this->getZeroOrNegativeValue());
    }

    /**
     * @return int
     */
    public function getPositiveValue(): int
    {
        return rand(1, PHP_INT_MAX);
    }

    /**
     * @return string
     */
    public function getPositiveValueAsString(): string
    {
        return strval($this->getPositiveValue());
    }

    /**
     * @return int
     */
    public function getNegativeValue(): int
    {
        return rand(PHP_INT_MIN, -1);
    }

    /**
     * @return string
     */
    public function getNegativeValueAsString(): string
    {
        return strval($this->getNegativeValue());
    }

    /**
     * @return string
     */
    public function getPositiveValueAndZeroOrNegativeValueAsString(): string
    {
        $values = [$this->getPositiveValue(), $this->getZeroOrNegativeValue()];

        return implode(",", $values);
    }

    /**
     * @return string
     */
    public function getPositiveValueAndNullValueAsString(): string
    {
        return "1," . null;
    }
}