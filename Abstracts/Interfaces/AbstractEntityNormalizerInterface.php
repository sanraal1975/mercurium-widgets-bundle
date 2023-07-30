<?php

namespace Comitium5\MercuriumWidgetsBundle\Abstracts\Interfaces;

/**
 * Interface AbstractEntityNormalizerInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Abstracts\Interfaces
 */
interface AbstractEntityNormalizerInterface
{
    /**
     * @param array $entity
     *
     * @return array
     */
    public function normalize(array $entity):array;
}