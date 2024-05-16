<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;

/**
 * Class BundleHomeMainArticleValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\ValueObjects
 */
abstract class BundleHomeMainArticleValueObject
{
    /**
     * @return Client
     */
    abstract public function getApi(): Client;

    /**
     * @return string
     */
    abstract public function getArticlesIds(): string;

    /**
     * @return string
     */
    abstract public function getFormat(): string;

    /**
     * @return bool
     */
    abstract public function getShowImage(): bool;

    /**
     * @return bool
     */
    abstract public function getShowNumComments(): bool;

    /**
     * @return bool
     */
    abstract public function getShowRelatedContent(): bool;

    /**
     * @return bool
     */
    abstract public function getShowSponsor(): bool;

    /**
     * @return bool
     */
    abstract public function getShowSubtitle(): bool;
}