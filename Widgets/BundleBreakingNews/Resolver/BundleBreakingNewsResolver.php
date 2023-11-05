<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Resolver;

use Comitium5\MercuriumWidgetsBundle\Resolvers\TwigResolver;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Helper\BundleBreakingNewsHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\ValueObject\BundleBreakingNewsValueObject;
use Exception;

/**
 * Class BundleBreakingNewsResolver
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Resolver
 */
class BundleBreakingNewsResolver
{
    /**
     * @var BundleBreakingNewsHelper
     */
    private $helper;

    /**
     * @param BundleBreakingNewsValueObject $valueObject
     *
     * @return void
     */
    public function __construct(BundleBreakingNewsValueObject $valueObject)
    {
        $this->helper = new BundleBreakingNewsHelper($valueObject);
    }

    /**
     * @param string $jsonFilePath
     *
     * @return string
     * @throws Exception
     */
    public function resolveContent(string $jsonFilePath): string
    {
        if (empty($jsonFilePath)) {
            return "";
        }

        if (!$this->helper->fileExists($jsonFilePath)) {
            return "";
        }

        return $this->helper->getJsonContent($jsonFilePath);
    }

}