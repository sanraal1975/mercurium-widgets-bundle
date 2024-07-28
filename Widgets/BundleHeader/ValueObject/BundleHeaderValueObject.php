<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Interfaces\BundleHeaderValueObjectInterface;

/**
 * Class BundleHeaderValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\ValueObject
 */
class BundleHeaderValueObject implements BundleHeaderValueObjectInterface
{
    /**
     * @var Client
     */
    protected $api;

    /**
     * @var array
     */
    private $locales;

    /**
     * @var string
     */
    private $subSiteAcronym;

    /**
     * @var array
     */
    private $pageFromRequest;

    /**
     * @var array
     */
    private $entityFromRequest;

    /**
     * @var int
     */
    private $homePageId;

    /**
     * @var int
     */
    private $searchPageId;

    /**
     * @var int
     */
    private $registerPageId;

    /**
     * @var int
     */
    private $loginPageId;

    /**
     * @var int
     */
    private $navItemsMenuId;

    /**
     * @var string
     */
    private $siteName;

    /**
     * @var string
     */
    private $siteUrl;

    /**
     * @param Client $api
     * @param array $locales
     * @param string $subSiteAcronym
     * @param array $pageFromRequest
     * @param array $entityFromRequest
     * @param int $homePageId
     * @param int $searchPageId
     * @param int $registerPageId
     * @param int $loginPageId
     * @param int $navItemsMenuId
     * @param string $siteName
     * @param string $siteUrl
     */
    public function __construct(
        Client     $api,
        array      $locales,
        string     $subSiteAcronym,
        array      $pageFromRequest,
        array      $entityFromRequest,
        int        $homePageId,
        int        $searchPageId,
        int        $registerPageId,
        int        $loginPageId,
        int        $navItemsMenuId,
        string     $siteName,
        string     $siteUrl
    )
    {
        $this->api = $api;
        $this->locales = $locales;
        $this->subSiteAcronym = $subSiteAcronym;
        $this->pageFromRequest = $pageFromRequest;
        $this->entityFromRequest = $entityFromRequest;
        $this->homePageId = $homePageId;
        $this->searchPageId = $searchPageId;
        $this->registerPageId = $registerPageId;
        $this->loginPageId = $loginPageId;
        $this->navItemsMenuId = $navItemsMenuId;
        $this->siteName = $siteName;
        $this->siteUrl = $siteUrl;
    }

    /**
     * @return Client
     */
    public function getApi(): Client
    {
        return $this->api;
    }

    /**
     * @return array
     */
    public function getLocales(): array
    {
        return $this->locales;
    }

    /**
     * @return string
     */
    public function getSubSiteAcronym(): string
    {
        return $this->subSiteAcronym;
    }

    /**
     * @return array
     */
    public function getPageFromRequest(): array
    {
        return $this->pageFromRequest;
    }

    /**
     * @return array
     */
    public function getEntityFromRequest(): array
    {
        return $this->entityFromRequest;
    }

    /**
     * @return int
     */
    public function getHomePageId(): int
    {
        return $this->homePageId;
    }

    /**
     * @return int
     */
    public function getSearchPageId(): int
    {
        return $this->searchPageId;
    }

    /**
     * @return int
     */
    public function getRegisterPageId(): int
    {
        return $this->registerPageId;
    }

    /**
     * @return int
     */
    public function getLoginPageId(): int
    {
        return $this->loginPageId;
    }

    /**
     * @return int
     */
    public function getNavItemsMenuId(): int
    {
        return $this->navItemsMenuId;
    }

    /**
     * @return string
     */
    public function getSiteName(): string
    {
        return $this->siteName;
    }

    /**
     * @return string
     */
    public function getSiteUrl(): string
    {
        return $this->siteUrl;
    }
}