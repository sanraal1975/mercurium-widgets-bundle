<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\Resolver;

use Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\Helper\BundleOpinionHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\ValueObject\BundleOpinionValueObject;
use Exception;

/**
 * Class BundleOpinionResolver
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\Resolver
 */
class BundleOpinionResolver
{
    /**
     * @var BundleOpinionValueObject
     */
    private $valueObject;

    /**
     * @var BundleOpinionHelper
     */
    private $helper;

    /**
     * @param BundleOpinionValueObject $valueObject
     */
    public function __construct(BundleOpinionValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
        $this->helper = new BundleOpinionHelper($valueObject);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function resolveSponsorImage(): array
    {
        return $this->helper->getSponsorImage();
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

        $jsonFilePath = $this->helper->getJsonFilePath();

        $jsonFilePath = str_replace("@SITE_PREFIX@", $this->valueObject->getSitePrefix(), $jsonFilePath);

        $jsonFilePath = str_replace("@SUBSITE_ACRONYM@", $this->valueObject->getSubSiteAcronym(), $jsonFilePath);

        $jsonFilePath = str_replace("@HOME_URL@", $this->valueObject->getHomeUrl(), $jsonFilePath);

        return $jsonFilePath . $jsonFile;
    }

    /**
     * @param string $jsonFilePath
     *
     * @return string
     * @throws Exception
     */
    public function resolveDeniedArticlesIds(string $jsonFilePath): string
    {
        if (empty($jsonFilePath)) {
            return "";
        }

        if (!$this->helper->fileExists($jsonFilePath)) {
            return "";
        }

        $jsonContent = $this->helper->getJsonContent($jsonFilePath);

        $localeIds = $this->helper->getLocaleIds($jsonContent);

        return $this->helper->getArticlesIdsFromArray($localeIds);
    }

}