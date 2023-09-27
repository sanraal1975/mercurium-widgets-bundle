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
     * @var EntityNormalizer
     */
    private $normalizer;

    /**
     * @param Client $api
     * @param string $articlesIds
     * @param EntityNormalizer $normalizer
     */
    public function __construct(Client $api, string $articlesIds, EntityNormalizer $normalizer)
    {
        $this->api = $api;
        $this->articlesIds = $articlesIds;
        $this->normalizer = $normalizer;
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
}