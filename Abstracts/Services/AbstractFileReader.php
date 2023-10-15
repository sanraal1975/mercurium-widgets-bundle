<?php

namespace Comitium5\MercuriumWidgetsBundle\Abstracts\Services;

use Comitium5\MercuriumWidgetsBundle\Abstracts\Interfaces\AbstractFileReaderInterface;

/**
 * Class AbstractFileReader
 *
 * @package Comitium5\MercuriumWidgetsBundle\Abstracts\Services
 */
abstract class AbstractFileReader implements AbstractFileReaderInterface
{
    /**
     * @return string
     */
    abstract public function read():string;
}