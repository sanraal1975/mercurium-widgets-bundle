<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Interfaces;

use Comitium5\ApiClientBundle\Client\Client;

/**
 * Interface BundleHeaderValueObjectInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Interfaces
 */
interface BundleHeaderValueObjectInterface
{
    /**
     * @return Client
     */
    public function getApi(): Client;

    /**
     * @return array
     */
    public function getLocales(): array;

    /**
     * @return string
     */
    public function getSubSiteAcronym(): string;

    /**
     * @return array
     */
    public function getPageFromRequest(): array;

    /**
     * @return array
     */
    public function getEntityFromRequest(): array;

    /**
     * @return int
     */
    public function getHomePageId(): int;

    /**
     * @return int
     */
    public function getSearchPageId(): int;

    /**
     * @return int
     */
    public function getRegisterPageId(): int;

    /**
     * @return int
     */
    public function getLoginPageId(): int;

    /**
     * @return int
     */
    public function getNavItemsMenuId(): int;

    /**
     * @return string
     */
    public function getSiteName(): string;

    /**
     * @return string
     */
    public function getSiteUrl(): string;
}