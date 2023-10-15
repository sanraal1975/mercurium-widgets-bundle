<?php

namespace Comitium5\MercuriumWidgetsBundle\Abstracts\Interfaces;

/**
 * Interface AbstractFileReaderInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Abstracts\Interfaces
 */
interface AbstractFileReaderInterface
{
    /**
     * @return string
     */
    public function read():string;
}