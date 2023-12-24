<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\ValueObject;

/**
 * Class BundleBreakingNewsValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\ValueObject
 */
abstract class BundleBreakingNewsValueObject
{
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
    abstract public function getHomeUrl(): string;

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
    abstract public function getJsonFile(): string;
}