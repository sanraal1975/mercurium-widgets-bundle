<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Services\FileReaders;

use Comitium5\MercuriumWidgetsBundle\Services\FileReaders\LocalFileReader;

/**
 * Class LocalFileReaderMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Services\FileReaders
 */
class LocalFileReaderMock extends LocalFileReader
{
    /**
     * @return false
     */
    public function getContents(): bool
    {
        return false;
    }
}