<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\ValueObject;

use Symfony\Bundle\TwigBundle\TwigEngine;

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

    /**
     * @return TwigEngine
     */
    abstract public function getTwig(): TwigEngine;
}