<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleRanking\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\ValueObject\BundleRankingValueObject;

/**
 * Class BundleRankingValueObjectMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleRanking\ValueObject
 */
class BundleRankingValueObjectMock extends BundleRankingValueObject
{
    /**
     * @var Client
     */
    protected $api;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $jsonFile;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @param Client $api
     * @param string $locale
     * @param string $jsonFile
     * @param int $quantity
     */
    public function __construct(
        Client     $api,
        string     $locale,
        string     $jsonFile,
        int        $quantity
    )
    {
        $this->api = $api;
        $this->locale = $locale;
        $this->jsonFile = $jsonFile;
        $this->quantity = $quantity;
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
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getJsonFile(): string
    {
        return $this->jsonFile;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}