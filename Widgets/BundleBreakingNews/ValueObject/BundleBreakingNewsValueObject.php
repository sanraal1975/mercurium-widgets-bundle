<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Interfaces\BundleBreakingNewsValueObjectInterface;

/**
 * Class BundleBreakingNewsValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\ValueObject
 */
class BundleBreakingNewsValueObject implements BundleBreakingNewsValueObjectInterface
{
    /**
     * @param Client $api
     * @param string $locale
     * @param string $sitePrefix
     * @param string $subSiteAcronym
     * @param string $homeUrl
     * @param string $environment
     * @param string $devJsonFilePath
     * @param string $prodJsonFilePath
     * @param string $jsonFile
     */
    public function __construct(
        private readonly Client $api,
        private readonly string $locale,
        private readonly string $sitePrefix,
        private readonly string $subSiteAcronym,
        private readonly string $homeUrl,
        private readonly string $environment,
        private readonly string $devJsonFilePath,
        private readonly string $prodJsonFilePath,
        private readonly string $jsonFile
    )
    {
    }

    /**
     * @return Client
     */
    public function getApi(): Client
    {
        return $this->api;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getSitePrefix(): string
    {
        return $this->sitePrefix;
    }

    /**
     * @return string
     */
    public function getSubSiteAcronym(): string
    {
        return $this->subSiteAcronym;
    }

    /**
     * @return string
     */
    public function getHomeUrl(): string
    {
        return $this->homeUrl;
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @return string
     */
    public function getDevJsonFilePath(): string
    {
        return $this->devJsonFilePath;
    }

    /**
     * @return string
     */
    public function getProdJsonFilePath(): string
    {
        return $this->prodJsonFilePath;
    }

    /**
     * @return string
     */
    public function getJsonFile(): string
    {
        return $this->jsonFile;
    }
}