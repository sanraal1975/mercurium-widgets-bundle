<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;

/**
 * Class BundleOpinionValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleOpinion\ValueObject
 */
abstract class BundleOpinionValueObject
{
    /**
     * @return Client
     */
    abstract public function getApi(): Client;

    /**
     * @return int
     */
    abstract public function getSponsorImageId(): int;

    /**
     * @return string
     */
    abstract public function getArticlesIds(): string;
}