<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Interfaces;

use Comitium5\ApiClientBundle\Client\Client;
use ComitiumSuite\Bundle\AppBundle\Security\User\ComitiumUser;

/**
 * Interface BundleHeaderRenderLoggedContentValueObjectInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Interfaces
 */
interface BundleHeaderRenderLoggedContentValueObjectInterface
{
    /**
     * @return Client
     */
    public function getApi(): Client;

    /**
     * @return string
     */
    public function getSubSiteAcronym(): string;

    /**
     * @return int
     */
    public function getAccountPageId(): int;

    /**
     * @return array
     */
    public function getUserData(): array;
}