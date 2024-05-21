<?php

namespace Comitium5\MercuriumWidgetsBundle\Interfaces;

/**
 * Interface EntityBasicInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Interfaces
 */
interface EntityGetByInterface
{
    /**
     * @param array $parameters
     *
     * @return array
     */
    public function getBy(array $parameters = []): array;
}