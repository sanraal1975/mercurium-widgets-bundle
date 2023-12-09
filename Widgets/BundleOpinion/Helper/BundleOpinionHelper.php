<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\Helper;

use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\ArrayHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ImageHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\FileHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\JsonHelper;
use Comitium5\MercuriumWidgetsBundle\Services\FileReaders\LocalFileReader;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleOpinion\ValueObject\BundleOpinionValueObject;
use Exception;

/**
 * Class BundleOpinionHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleOpinion\Helper
 */
class BundleOpinionHelper
{
    /**
     * @var BundleOpinionValueObject
     */
    private $valueObject;

    /**
     * @param BundleOpinionValueObject $valueObject
     */
    public function __construct(BundleOpinionValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    /**
     * @return BundleOpinionValueObject
     */
    public function getValueObject(): BundleOpinionValueObject
    {
        return $this->valueObject;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getSponsorImage(): array
    {
        $imageId = $this->valueObject->getSponsorImageId();

        if (empty($imageId)) {
            return [];
        }
        $api = $this->valueObject->getApi();
        $imageHelper = new ImageHelper($api);

        return $imageHelper->get($imageId);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getManualArticles(): array
    {
        $api = $this->valueObject->getApi();
        $helper = new ArticleHelper($api);

        return $helper->getByIds($this->valueObject->getArticlesIds());
    }

    /**
     * @param string $deniedArticlesIds
     *
     * @return array
     * @throws Exception
     */
    public function getAutomaticArticles(string $deniedArticlesIds): array
    {
        $api = $this->valueObject->getApi();
        $quantity = $this->valueObject->getQuantity();

        if (empty($quantity)) {
            return [];
        }

        $parameters = [
            "page" => 1,
            "limit" => $quantity
        ];

        $categoryId = $this->valueObject->getCategoryOpinionId();
        if (!empty($categoryId)) {
            $parameters["categories"] = $categoryId;
        }

        if (!empty($deniedArticlesIds)) {
            $parameters["exclude_ids"] = $deniedArticlesIds;
        }

        $helper = new ArticleHelper($api);
        $articles = $helper->getBy($parameters);

        return ApiResultsHelper::extractResults($articles);
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
}