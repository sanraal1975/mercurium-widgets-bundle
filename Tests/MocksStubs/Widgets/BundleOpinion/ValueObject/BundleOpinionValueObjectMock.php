<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleOpinion\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\ValueObject\BundleOpinionValueObject;

/**
 * Class BundleOpinionValueObjectMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleOpinion\ValueObject
 */
class BundleOpinionValueObjectMock extends BundleOpinionValueObject
{
    /**
     * @var Client
     */
    protected $api;

    /**
     * @var int
     */
    private $sponsorImageId;

    /**
     * @var string
     */
    private $articlesIds;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var int
     */
    private $categoryOpinionId;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $jsonFile;

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
    private $sitePrefix;

    /**
     * @var string
     */
    private $homeUrl;

    /**
     * @var string
     */
    private $subSiteAcronym;

    /**
     * @param Client $api
     * @param int $sponsorImageId
     * @param string $articlesIds
     * @param int $quantity
     * @param int $categoryOpinionId
     * @param string $locale
     * @param string $jsonFile
     * @param string $environment
     * @param string $devJsonFilePath
     * @param string $prodJsonFilePath
     * @param string $sitePrefix
     * @param string $homeUrl
     * @param string $subSiteAcronym
     */
    public function __construct(
        Client $api,
        int    $sponsorImageId = 1,
        string $articlesIds = "",
        int    $quantity = 1,
        int    $categoryOpinionId = 1,
        string $locale = "ca",
        string $jsonFile = "home_articles.json",
        string $environment = "dev",
        string $devJsonFilePath = "foo.bar",
        string $prodJsonFilePath = "foo.bar",
        string $sitePrefix = "foo.bar",
        string $homeUrl = "https://foo.bar",
        string $subSiteAcronym = "foo.bar"
    )
    {
        $this->api = $api;
        $this->sponsorImageId = $sponsorImageId;
        $this->articlesIds = $articlesIds;
        $this->quantity = $quantity;
        $this->categoryOpinionId = $categoryOpinionId;
        $this->locale = $locale;
        $this->jsonFile = $jsonFile;
        $this->environment = $environment;
        $this->devJsonFilePath = $devJsonFilePath;
        $this->prodJsonFilePath = $prodJsonFilePath;
        $this->sitePrefix = $sitePrefix;
        $this->homeUrl = $homeUrl;
        $this->subSiteAcronym = $subSiteAcronym;
    }

    /**
     * @return Client
     */
    public function getApi(): Client
    {
        return $this->api;
    }

    /**
     * @return int
     */
    public function getSponsorImageId(): int
    {
        return $this->sponsorImageId;
    }

    /**
     * @return string
     */
    public function getArticlesIds(): string
    {
        return $this->articlesIds;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getCategoryOpinionId(): int
    {
        return $this->categoryOpinionId;
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
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @return string
     */
    public function getJsonFile(): string
    {
        return $this->jsonFile;
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
    public function getSitePrefix(): string
    {
        return $this->sitePrefix;
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
    public function getSubSiteAcronym(): string
    {
        return $this->subSiteAcronym;
    }
}