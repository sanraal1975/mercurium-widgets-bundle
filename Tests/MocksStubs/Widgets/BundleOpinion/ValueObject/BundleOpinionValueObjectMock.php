<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleOpinion\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\ValueObject\BundleOpinionValueObject;

/**
 * Class BundleOpinionValueObjectMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleOpinion\ValueObject
 */
class BundleOpinionValueObjectMock extends BundleOpinionValueObject
{
    /**
     * @var Client
     */
    protected $api;

    /**
     * @var int
     */
    private $sponsorImageId;

    /**
     * @var string
     */
    private $articlesIds;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var int
     */
    private $categoryOpinionId;

    /**
     * @param Client $api
     * @param int $sponsorImageId
     * @param string $articlesIds
     * @param int $quantity
     * @param int $categoryOpinionId
     */
    public function __construct(
        Client $api,
        int    $sponsorImageId,
        string $articlesIds,
        int    $quantity,
        int    $categoryOpinionId
    )
    {
        $this->api = $api;
        $this->sponsorImageId = $sponsorImageId;
        $this->articlesIds = $articlesIds;
        $this->quantity = $quantity;
        $this->categoryOpinionId = $categoryOpinionId;
    }

    /**
     * @return Client
     */
    public function getApi(): Client
    {
        return $this->api;
    }

    /**
     * @return int
     */
    public function getSponsorImageId(): int
    {
        return $this->sponsorImageId;
    }

    /**
     * @return string
     */
    public function getArticlesIds(): string
    {
        return $this->articlesIds;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getCategoryOpinionId(): int
    {
        return $this->categoryOpinionId;
    }

}