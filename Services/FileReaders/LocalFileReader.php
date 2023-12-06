<?php

namespace Comitium5\MercuriumWidgetsBundle\Services\FileReaders;

use Comitium5\MercuriumWidgetsBundle\Abstracts\Services\AbstractFileReader;
use Exception;

/**
 * Class LocalFileReader
 *
 * @package Comitium5\MercuriumWidgetsBundle\Services\FileReaders
 */
class LocalFileReader extends AbstractFileReader
{
    const EMPTY_URL = "LocalFileReader::validate. Url can not be empty";

    /**
     * @var string
     */
    private $url;

    /**
     * @param string $url
     * @throws Exception
     */
    public function __construct(string $url)
    {
        $this->url = $url;

        $this->validate();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function validate()
    {
        if (empty($this->url)) {
            throw new Exception(self::EMPTY_URL);
        }
    }

    /**
     * @return string
     */
    public function read(): string
    {
        $contents = $this->getContents();

        if ($contents === false) {
            return "";
        }

        return $contents;
    }

    /**
     * @return false|string
     */
    public function getContents()
    {
        return file_get_contents($this->url);
    }
}