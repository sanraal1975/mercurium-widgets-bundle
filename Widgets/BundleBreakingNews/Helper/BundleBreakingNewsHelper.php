<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Helper;

use Comitium5\MercuriumWidgetsBundle\Helpers\FileHelper;
use Comitium5\MercuriumWidgetsBundle\Services\FileReaders\LocalFileReader;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\ValueObject\BundleBreakingNewsValueObject;
use Exception;

/**
 * Class BundleBreakingNewsHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleBreakingNews\Helper
 */
class BundleBreakingNewsHelper
{
    /**
     * @var BundleBreakingNewsValueObject
     */
    private $valueObject;

    /**
     * @param BundleBreakingNewsValueObject $valueObject
     */
    public function __construct(BundleBreakingNewsValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    /**
     * @return BundleBreakingNewsValueObject
     */
    public function getValueObject(): BundleBreakingNewsValueObject
    {
        return $this->valueObject;
    }

    /**
     * @param string $jsonFilePath
     *
     * @return bool
     */
    public function fileExists(string $jsonFilePath): bool
    {
        $environment = $this->valueObject->getEnvironment();

        $helper = new FileHelper($jsonFilePath);

        if ($environment == "prod") {
            return $helper->fileExistsLocal();
        }

        return $helper->fileExistsRemote();
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