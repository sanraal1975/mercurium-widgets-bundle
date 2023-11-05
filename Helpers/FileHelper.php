<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers;

use Exception;

/**
 * Class FileHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers
 */
class FileHelper
{
    const EMPTY_FILE = "FileHelper::validate. file can not be empty";

    /**
     * @var string
     */
    private $filePath;

    /**
     * @param string $filePath
     * @throws Exception
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;

        $this->validate();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function validate()
    {
        if (empty($this->filePath)) {
            throw new Exception(self::EMPTY_FILE);
        }
    }

    /**
     * @return bool
     */
    public function fileExists(): bool
    {
        $handle = @fopen($this->filePath, 'r');
        if (!$handle) {
            return false;
        }
        fclose($handle);

        return true;
    }
}