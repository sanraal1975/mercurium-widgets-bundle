<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Resolver;

use Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Helper\BundleBreakingNewsHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Interfaces\BundleBreakingNewsValueObjectInterface;
use Exception;

/**
 * Class BundleBreakingNewsResolver
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Resolver
 */
class BundleBreakingNewsResolver
{
    /**
     * @var BundleBreakingNewsValueObjectInterface
     */
    private $valueObject;

    /**
     * @var BundleBreakingNewsHelper
     */
    private $helper;

    /**
     * @param BundleBreakingNewsValueObjectInterface $valueObject
     *
     * @return void
     */
    public function __construct(BundleBreakingNewsValueObjectInterface $valueObject)
    {
        $this->valueObject = $valueObject;
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

    /**
     * @return string
     * @throws Exception
     */
    public function resolveJsonFilePath(): string
    {
        $jsonFile = $this->valueObject->getJsonFile();

        if (empty($jsonFile)) {
            return "";
        }

        $filePath = $this->helper->getJsonFilePath();

        $filePath = str_replace("@SITE_PREFIX@", $this->valueObject->getSitePrefix(), $filePath);

        $filePath = str_replace("@SUBSITE_ACRONYM@", $this->valueObject->getSubSiteAcronym(), $filePath);

        $filePath = str_replace("@HOME_URL@", $this->valueObject->getHomeUrl(), $filePath);

        $jsonFile = str_replace("@LOCALE@", $this->valueObject->getLocale(), $jsonFile);

        return $filePath . $jsonFile;
    }
}