<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\HomeMainArticle\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;

/**
 * Class HomeMainArticleValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\ValueObjects
 */
class HomeMainArticleValueObject
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
     * @return Client
     */
    public function getApi(): Client
    {
        return $this->api;
    }

    /**
     * @return string
     */
    public function getArticlesIds(): string
    {
        return $this->articlesIds;
    }

    /**
     * @return EntityNormalizer
     */
    public function getNormalizer(): EntityNormalizer
    {
        return $this->normalizer;
    }
}