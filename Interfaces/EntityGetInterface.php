<?php

namespace Comitium5\MercuriumWidgetsBundle\Interfaces;

/**
 * Interface EntityBasicInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Interfaces
 */
interface EntityGetInterface
{
    /**
     * @param int $entityId
     *
     * @return array
     */
    public function get(int $entityId): array;
}