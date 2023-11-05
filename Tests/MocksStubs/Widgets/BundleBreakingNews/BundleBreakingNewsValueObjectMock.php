<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleBreakingNews;

use Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\ValueObject\BundleBreakingNewsValueObject;

/**
 * Class BundleBreakingNewsValueObjectMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleBreakingNews
 */
class BundleBreakingNewsValueObjectMock extends BundleBreakingNewsValueObject
{
    /**
     * @var string
     */
    private $environment;

    /**
     * @param string $environment
     */
    public function __construct(string $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }
}