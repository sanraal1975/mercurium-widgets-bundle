<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Interfaces;

/**
 * Interface BundleBreakingNewsValueObjectInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Interfaces
 */
interface BundleBreakingNewsValueObjectInterface
{
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
    public function getHomeUrl(): string;

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
    public function getJsonFile(): string;

    /**
     * @return string
     */
    public function getEnvironment(): string;
}