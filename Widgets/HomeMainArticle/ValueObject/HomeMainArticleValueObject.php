<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\HomeMainArticle\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;

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
     * @param Client $api
     * @param string $articlesIds
     */
    public function __construct(Client $api, string $articlesIds)
    {
        $this->api = $api;
        $this->articlesIds = $articlesIds;
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
}