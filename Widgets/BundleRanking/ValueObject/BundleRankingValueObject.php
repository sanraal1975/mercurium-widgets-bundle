<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;

/**
 * Class BundleRankingValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\ValueObject
 */
abstract class BundleRankingValueObject
{
    /**
     * @return Client
     */
    abstract public function getApi(): Client;

    /**
     * @return string
     */
    abstract public function getLocale(): string;

    /**
     * @return string
     */
    abstract public function getSubSiteAcronym(): string;

    /**
     * @return mixed
     */
    abstract public function getSitePrefix();

    /**
     * @return string
     */
    abstract public function getJsonFile(): string;

    /**
     * @return int
     */
    abstract public function getQuantity(): int;

    /**
     * @return string
     */
    abstract public function getEnvironment(): string;

    /**
     * @return string
     */
    abstract public function getDevJsonFilePath(): string;

    /**
     * @return string
     */
    abstract public function getProdJsonFilePath(): string;

    /**
     * @return string
     */
    abstract public function getHomeUrl(): string;
}