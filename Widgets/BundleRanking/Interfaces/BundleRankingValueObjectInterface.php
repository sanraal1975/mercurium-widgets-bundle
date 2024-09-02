<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Interfaces;

use Comitium5\ApiClientBundle\Client\Client;

/**
 * Interface BundleRankingValueObjectInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Interfaces
 */
interface BundleRankingValueObjectInterface
{
    /**
     * @return Client
     */
    public function getApi(): Client;

    /**
     * @return string
     */
    public function getLocale(): string;

    /**
     * @return string
     */
    public function getSubSiteAcronym(): string;

    /**
     * @return string
     */
    public function getSitePrefix(): string;

    /**
     * @return string
     */
    public function getJsonFile(): string;

    /**
     * @return int
     */
    public function getQuantity(): int;

    /**
     * @return string
     */
    public function getEnvironment(): string;

    /**
     * @return string
     */
    public function getDevJsonFilePath(): string;

    /**
     * @return string
     */
    public function getProdJsonFilePath(): string;

    /**
     * @return string
     */
    public function getHomeUrl(): string;
}