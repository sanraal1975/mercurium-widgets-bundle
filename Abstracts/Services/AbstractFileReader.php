<?php

namespace Comitium5\MercuriumWidgetsBundle\Abstracts\Services;

/**
 * Class AbstractFileReader
 *
 * @package Comitium5\MercuriumWidgetsBundle\Abstracts\Services
 */
abstract class AbstractFileReader
{
    /**
     * @var string
     */
    private $url;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    abstract public function read():string;

}