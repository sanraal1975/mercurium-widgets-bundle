<?php

namespace Comitium5\MercuriumWidgetsBundle\Interfaces;

/**
 * Interface TranslatorServiceInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Interfaces
 */
interface TranslatorServiceInterface
{
    /**
     * @param string $translationKey
     * @param array $parameters
     *
     * @return string
     */
    public function trans(string $translationKey, array $parameters = []): string;
}