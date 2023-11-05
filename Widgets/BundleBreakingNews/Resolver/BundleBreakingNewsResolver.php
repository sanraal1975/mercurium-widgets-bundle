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
     * @var BundleBreakingNewsValueObject
     */
    private $valueObject;

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
        $this->valueObject = $valueObject;
        $this->helper = new BundleBreakingNewsHelper($valueObject);
    }

    /**
     * @param string $ribbonTwigFile
     * @param array $replacements
     * @param string $search
     *
     * @return array|string|string[]
     */
    public function resolveRibbonTwig(string $ribbonTwigFile, array $replacements = [], string $search = "@TRANSLATION_GROUP@")
    {
        $twig = $this->valueObject->getTwig();

        $twigResolver = new TwigResolver($twig);

        return $twigResolver->resolve($ribbonTwigFile, $search, $replacements);
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