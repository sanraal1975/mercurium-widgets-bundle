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
    const IMAGE_FIELD_KEY = "image";
    const VIDEO_FIELD_KEY = "video";
    const AUTHOR_FIELD_KEY = "author";

    /**
     * @return Client
     */
    public function getApi(): Client
    {
        return new Client("https://foo.bar", "fake_token");
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