<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Resolver;

use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Helper\BundleRankingHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Interfaces\BundleRankingValueObjectInterface;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Normalizer\BundleRankingNormalizer;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\ValueObject\BundleRankingValueObject;
use Exception;

/**
 * Class BundleRankingResolver
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Resolver
 */
class BundleRankingResolver
{
    /**
     * @var BundleRankingValueObject
     */
    private $valueObject;

    /**
     * @var BundleRankingHelper
     */
    private $helper;

    /**
     * @var BundleRankingNormalizer
     */
    private $normalizer;

    /**
     * @param BundleRankingValueObjectInterface $valueObject
     * @param EntityNormalizer $normalizer
     */
    public function __construct(BundleRankingValueObjectInterface $valueObject, EntityNormalizer $normalizer)
    {
        $this->valueObject = $valueObject;
        $this->helper = new BundleRankingHelper($valueObject);
        $this->normalizer = new BundleRankingNormalizer($normalizer);
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

        $jsonFile = str_replace("@SUBSITE_ACRONYM@", $this->valueObject->getSubSiteAcronym(), $jsonFile);

        $jsonFilePath = $this->helper->getJsonFilePath();

        $jsonFilePath = str_replace("@SITE_PREFIX@", $this->valueObject->getSitePrefix(), $jsonFilePath);

        $jsonFilePath = str_replace("@SUBSITE_ACRONYM@", $this->valueObject->getSubSiteAcronym(), $jsonFilePath);

        $jsonFilePath = str_replace("@HOME_URL@", $this->valueObject->getHomeUrl(), $jsonFilePath);

        return $jsonFilePath . $jsonFile;
    }

    /**
     * @param string $jsonFilePath
     *
     * @return array
     * @throws Exception
     */
    public function resolveArticles(string $jsonFilePath): array
    {
        if (empty($jsonFilePath)) {
            return [];
        }

        if (!$this->helper->fileExists($jsonFilePath)) {
            return [];
        }

        $jsonContent = $this->helper->getJsonContent($jsonFilePath);
        $localeIds = $this->helper->getLocaleIds($jsonContent);
        $articlesIds = $this->helper->getArticlesIdsFromArray($localeIds);
        $articles = $this->helper->getArticles($articlesIds);

        return $this->normalizer->normalize($articles);
    }
}