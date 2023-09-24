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
}