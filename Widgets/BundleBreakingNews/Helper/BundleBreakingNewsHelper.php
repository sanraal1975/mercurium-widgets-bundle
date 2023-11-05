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