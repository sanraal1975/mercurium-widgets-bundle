<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\ValueObject;

/**
 * Class BundleBreakingNewsValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\ValueObject
 */
abstract class BundleBreakingNewsValueObject
{
    /**
     * @return string
     */
    abstract public function getEnvironment(): string;
}