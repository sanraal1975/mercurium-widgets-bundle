<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleBreakingNews;

use Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Interfaces\BundleBreakingNewsValueObjectInterface;

/**
 * Class BundleBreakingNewsValueObjectMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleBreakingNews
 */
class BundleBreakingNewsValueObjectMock implements BundleBreakingNewsValueObjectInterface
{
    /**
     * @var string
     */
    private $environment;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $sitePrefix;

    /**
     * @var string
     */
    private $subSiteAcronym;

    /**
     * @var string
     */
    private $homeUrl;

    /**
     * @var string
     */
    private $devJsonFilePath;

    /**
     * @var string
     */
    private $prodJsonFilePath;

    /**
     * @var string
     */
    private $jsonFile;

    /**
     * @param string $environment
     * @param string $locale
     * @param string $sitePrefix
     * @param string $subSiteAcronym
     * @param string $homeUrl
     * @param string $devJsonFilePath
     * @param string $prodJsonFilePath
     * @param string $jsonFile
     */
    public function __construct(
        string $environment,
        string $locale,
        string $sitePrefix,
        string $subSiteAcronym,
        string $homeUrl,
        string $devJsonFilePath,
        string $prodJsonFilePath,
        string $jsonFile
    )
    {
        $this->environment = $environment;
        $this->locale = $locale;
        $this->sitePrefix = $sitePrefix;
        $this->subSiteAcronym = $subSiteAcronym;
        $this->homeUrl = $homeUrl;
        $this->devJsonFilePath = $devJsonFilePath;
        $this->prodJsonFilePath = $prodJsonFilePath;
        $this->jsonFile = $jsonFile;
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