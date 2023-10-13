<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Helper;

use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\ArrayHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\JsonHelper;
use Comitium5\MercuriumWidgetsBundle\Services\FileReaders\LocalFileReader;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\ValueObject\BundleRankingValueObject;
use Exception;

/**
 * Class BundleRankingHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleRanking\Helper
 */
class BundleRankingHelper
{
    /**
     * @var BundleRankingValueObject
     */
    private $valueObject;

    /**
     * @param BundleRankingValueObject $valueObject
     */
    public function __construct(BundleRankingValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    /**
     * @return BundleRankingValueObject
     */
    public function getValueObject(): BundleRankingValueObject
    {
        return $this->valueObject;
    }

    /**
     * @param string $jsonFilePath
     *
     * @return string
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
    public function getLocaleIds(string $jsonContent)
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