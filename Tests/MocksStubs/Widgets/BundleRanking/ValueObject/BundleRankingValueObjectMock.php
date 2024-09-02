<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleRanking\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Interfaces\BundleRankingValueObjectInterface;

/**
 * Class BundleRankingValueObjectMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleRanking\ValueObject
 */
class BundleRankingValueObjectMock implements BundleRankingValueObjectInterface
{
    /**
     * @var Client
     */
    protected $api;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $jsonFile;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var string
     */
    private $environment;

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
    private $homeUrl;

    /**
     * @var string
     */
    private $subSiteAcronym;

    /**
     * @var string
     */
    private $sitePrefix;

    /**
     * @param Client $api
     * @param string $locale
     * @param string $jsonFile
     * @param int $quantity
     * @param string $environment
     * @param string $devJsonFilePath
     * @param string $prodJsonFilePath
     * @param string $homeUrl
     * @param string $subSiteAcronym
     * @param string $sitePrefix
     */
    public function __construct(
        Client $api,
        string $locale,
        string $jsonFile,
        int    $quantity,
        string $environment,
        string $devJsonFilePath,
        string $prodJsonFilePath,
        string $homeUrl,
        string $subSiteAcronym,
        string $sitePrefix
    )
    {
        $this->api = $api;
        $this->locale = $locale;
        $this->jsonFile = $jsonFile;
        $this->quantity = $quantity;
        $this->environment = $environment;
        $this->devJsonFilePath = $devJsonFilePath;
        $this->prodJsonFilePath = $prodJsonFilePath;
        $this->homeUrl = $homeUrl;
        $this->subSiteAcronym = $subSiteAcronym;
        $this->sitePrefix = $sitePrefix;
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
    public function getSubSiteAcronym(): string
    {
        return $this->subSiteAcronym;
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
    public function getJsonFile(): string
    {
        return $this->jsonFile;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
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
    public function getHomeUrl(): string
    {
        return $this->homeUrl;
    }
}