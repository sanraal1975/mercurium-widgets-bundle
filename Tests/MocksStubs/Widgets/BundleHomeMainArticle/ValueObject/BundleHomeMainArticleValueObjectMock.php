<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleHomeMainArticle\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\ValueObject\BundleHomeMainArticleValueObject;

/**
 * Class BundleHomeMainArticleValueObjectMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleHomeMainArticle\ValueObject
 */
class BundleHomeMainArticleValueObjectMock extends BundleHomeMainArticleValueObject
{
    /**
     * @var Client
     */
    private $api;

    /**
     * @var string
     */
    private $articlesIds;

    /**
     * @param Client $api
     * @param string $articlesIds
     */
    public function __construct(Client $api, string $articlesIds)
    {
        $this->api = $api;
        $this->articlesIds = $articlesIds;
    }

    /**
     * @inheritDoc
     */
    public function getApi(): Client
    {
        return $this->api;
    }

    /**
     * @inheritDoc
     */
    public function getArticlesIds(): string
    {
        return $this->articlesIds;
    }

    public function getFormat(): string
    {
        // TODO: Implement getFormat() method.
    }

    public function getShowImage(): bool
    {
        // TODO: Implement getShowImage() method.
    }

    public function getShowNumComments(): bool
    {
        // TODO: Implement getShowNumComments() method.
    }

    public function getShowRelatedContent(): bool
    {
        // TODO: Implement getShowRelatedContent() method.
    }

    public function getShowSponsor(): bool
    {
        // TODO: Implement getShowSponsor() method.
    }

    public function getShowSubtitle(): bool
    {
        // TODO: Implement getShowSubtitle() method.
    }
}