<?php

namespace Comitium5\MercuriumWidgetsBundle\Services;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class TranslatorService
 *
 * @package Comitium5\MercuriumWidgetsBundle\Services
 */
class TranslatorService
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $domain;

    /**
     * @param TranslatorInterface $translator
     * @param string $locale
     * @param string $domain
     */
    public function __construct(
        TranslatorInterface $translator,
        string $locale,
        string $domain
    )
    {
        $this->translator = $translator;;
        $this->locale = $locale;
        $this->domain = $domain;
    }

    /**
     * @param string $translationKey
     * @param array $parameters
     *
     * @return string
     */
    public function trans(string $translationKey, array $parameters = []): string
    {
        return $this->translator->trans($translationKey, $parameters, $this->domain, $this->locale);
    }
}