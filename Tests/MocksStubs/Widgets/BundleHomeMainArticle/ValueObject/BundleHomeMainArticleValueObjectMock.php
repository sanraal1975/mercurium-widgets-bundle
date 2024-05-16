<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleHomeMainArticle\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
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
     * @var string
     */
    private $format;

    /**
     * @var bool
     */
    private $showImage;

    /**
     * @var bool
     */
    private $showNumComments;

    /**
     * @var bool
     */
    private $showRelatedContent;

    /**
     * @var bool
     */
    private $showSponsor;

    /**
     * @var bool
     */
    private $showSubtitle;

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

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @return bool
     */
    public function getShowImage(): bool
    {
        return $this->showImage;
    }

    /**
     * @return bool
     */
    public function getShowNumComments(): bool
    {
        return $this->showNumComments;
    }

    /**
     * @return bool
     */
    public function getShowRelatedContent(): bool
    {
        return $this->showRelatedContent;
    }

    /**
     * @return bool
     */
    public function getShowSponsor(): bool
    {
        return $this->showSponsor;
    }

    /**
     * @return bool
     */
    public function getShowSubtitle(): bool
    {
        return $this->showSubtitle;
    }

}