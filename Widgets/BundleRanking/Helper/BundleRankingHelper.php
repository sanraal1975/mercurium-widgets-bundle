<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Helper;

use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\ArrayHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\FileHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\JsonHelper;
use Comitium5\MercuriumWidgetsBundle\Services\FileReaders\LocalFileReader;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Interfaces\BundleRankingValueObjectInterface;
use Exception;

/**
 * Class BundleRankingHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Helper
 */
class BundleRankingHelper
{
    /**
     * @var BundleRankingValueObjectInterface
     */
    private $valueObject;

    /**
     * @param BundleRankingValueObjectInterface $valueObject
     */
    public function __construct(BundleRankingValueObjectInterface $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    /**
     * @return string
     */
    public function getJsonFilePath(): string
    {
        $jsonFile = $this->valueObject->getJsonFile();

        if (empty($jsonFile)) {
            return "";
        }

        $environment = $this->valueObject->getEnvironment();

        if ($environment == BundleConstants::ENVIRONMENT_DEV) {
            return $this->valueObject->getDevJsonFilePath();
        }

        return $this->valueObject->getProdJsonFilePath();
    }

    /**
     * @param string $filePath
     *
     * @return bool
     * @throws Exception
     */
    public function fileExists(string $filePath): bool
    {
        if (empty($filePath)) {
            return false;
        }

        $helper = new FileHelper($filePath);

        return $helper->fileExists();
    }

    /**
     * @param string $jsonFilePath
     *
     * @return string
     * @throws Exception
     */
    public function getJsonContent(string $jsonFilePath): string
    {
        if (empty($jsonFilePath)) {
            return "";
        }

        $fileReader = new LocalFileReader($jsonFilePath);

        return $fileReader->read();
    }

    /**
     * @param string $jsonContent
     *
     * @return array|mixed
     */
    public function getLocaleIds(string $jsonContent): mixed
    {
        if (empty($jsonContent)) {
            return [];
        }

        $locale = $this->valueObject->getLocale();
        $helper = new JsonHelper();

        return $helper->getLocaleIds($jsonContent, $locale);
    }

    /**
     * @param array $localeIds
     *
     * @return string
     */
    public function getArticlesIdsFromArray(array $localeIds): string
    {
        if (empty($localeIds)) {
            return "";
        }

        $helper = new ArrayHelper();
        $articlesIds = $helper->getItemsFieldValue($localeIds, EntityConstants::ID_FIELD_KEY);

        return implode(",", $articlesIds);
    }

    /**
     * @param string $articlesIds
     *
     * @return array
     * @throws Exception
     */
    public function getArticles(string $articlesIds): array
    {
        if (empty($articlesIds)) {
            return [];
        }

        $quantity = $this->valueObject->getQuantity();

        $helper = new ArticleHelper($this->valueObject->getApi());

        return $helper->getByIdsAndQuantity($articlesIds, $quantity);
    }
}