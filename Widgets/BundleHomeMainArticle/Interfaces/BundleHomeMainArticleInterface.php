<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Interfaces;

use Comitium5\ApiClientBundle\Client\Client;

/**
 * Interface BundleHomeMainArticleInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Interfaces
 */
interface BundleHomeMainArticleInterface
{
    /**
     * @return Client
     */
    public function getApi(): Client;

    /**
     * @return string
     */
    public function getArticlesIds(): string;

    /**
     * @return string
     */
    public function getFormat(): string;

    /**
     * @return bool
     */
    public function getShowImage(): bool;

    /**
     * @return bool
     */
    public function getShowNumComments(): bool;

    /**
     * @return bool
     */
    public function getShowRelatedContent(): bool;

    /**
     * @return bool
     */
    public function getShowSponsor(): bool;

    /**
     * @return bool
     */
    public function getShowSubtitle(): bool;
}