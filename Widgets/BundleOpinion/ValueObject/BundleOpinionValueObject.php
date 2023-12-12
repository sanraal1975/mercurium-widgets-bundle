<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;

/**
 * Class BundleOpinionValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleOpinion\ValueObject
 */
abstract class BundleOpinionValueObject
{
    /**
     * @return Client
     */
    abstract public function getApi(): Client;

    /**
     * @return mixed
     */
    abstract public function getSitePrefix();

    /**
     * @return mixed
     */
    abstract public function getSubSiteAcronym();

    /**
     * @return string
     */
    abstract public function getLocale(): string;

    /**
     * @return int
     */
    abstract public function getSponsorImageId(): int;

    /**
     * @return string
     */
    abstract public function getArticlesIds(): string;

    /**
     * @return int
     */
    abstract public function getQuantity(): int;

    /**
     * @return int
     */
    abstract public function getCategoryOpinionId(): int;

    /**
     * @return string
     */
    abstract public function getEnvironment(): string;

    /**
     * @return string
     */
    abstract public function getJsonFile(): string;

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