<?php

namespace Comitium5\MercuriumWidgetsBundle\Services\FileReaders;

use Comitium5\MercuriumWidgetsBundle\Abstracts\Services\AbstractFileReader;

/**
 * Class LocalFileReader
 *
 * @package Comitium5\MercuriumWidgetsBundle\Services\FileReaders
 */
class LocalFileReader extends AbstractFileReader
{
    /**
     * @return string
     */
    public function read(): string
    {
        $url = $this->getUrl();

        if (empty($url)) {
            return "";
        }

        $contents = file_get_contents($url);

        return ($contents === false) ? "" : $contents;
    }
}