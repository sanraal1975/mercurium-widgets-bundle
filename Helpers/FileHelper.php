<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers;

/**
 * Class FileHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers
 */
class FileHelper
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @param string $filePath
     */
    public function __construct(string $filePath = "")
    {
        $this->filePath = $filePath;
    }

    /**
     * @return bool
     */
    public function fileExistsLocal(): bool
    {
        if (empty($this->filePath)) {
            return false;
        }

        return file_exists($this->filePath);
    }

    /**
     * @return bool
     */
    public function fileExistsRemote(): bool
    {
        if (empty($this->filePath)) {
            return false;
        }

        $handle = @fopen($this->filePath, 'r');
        if (!$handle) {
            return false;
        }
        fclose($handle);

        return true;
    }
}