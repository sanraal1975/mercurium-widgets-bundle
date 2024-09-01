<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Helper;

use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\FileHelper;
use Comitium5\MercuriumWidgetsBundle\Services\FileReaders\LocalFileReader;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Interfaces\BundleBreakingNewsValueObjectInterface;
use Exception;

/**
 * Class BundleBreakingNewsHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Helper
 */
class BundleBreakingNewsHelper
{
    /**
     * @param BundleBreakingNewsValueObjectInterface $valueObject
     */
    public function __construct(private readonly BundleBreakingNewsValueObjectInterface $valueObject)
    {
    }

    /**
     * @return BundleBreakingNewsValueObjectInterface
     */
    public function getValueObject(): BundleBreakingNewsValueObjectInterface
    {
        return $this->valueObject;
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
}