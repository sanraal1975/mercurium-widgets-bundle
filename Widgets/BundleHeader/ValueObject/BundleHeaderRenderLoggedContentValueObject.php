<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Interfaces\BundleHeaderRenderLoggedContentValueObjectInterface;

/**
 * Class BundleHeaderRenderLoggedContentValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\ValueObject
 */
class BundleHeaderRenderLoggedContentValueObject implements BundleHeaderRenderLoggedContentValueObjectInterface
{
    /**
     * @var Client
     */
    private $api;

    /**
     * @var string
     */
    private $subSiteAcronym;

    /**
     * @var int;
     */
    private $accountPageId;

    /**
     * @var array
     */
    private $userData;

    /**
     * @param Client $api
     * @param string $subSiteAcronym
     * @param int $accountPageId
     * @param array $userData
     */
    public function __construct(
        Client $api,
        string $subSiteAcronym,
        int    $accountPageId,
        array  $userData
    )
    {
        $this->api = $api;
        $this->subSiteAcronym = $subSiteAcronym;
        $this->accountPageId = $accountPageId;
        $this->userData = $userData;
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
    public function getSubSiteAcronym(): string
    {
        return $this->subSiteAcronym;
    }

    /**
     * @return int
     */
    public function getAccountPageId(): int
    {
        return $this->accountPageId;
    }

    /**
     * @return array
     */
    public function getUserData(): array
    {
        return $this->userData;
    }
}