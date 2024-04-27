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
        string              $domain,
        string              $locale
    )
    {
        $this->translator = $translator;;
        $this->domain = $domain;
        $this->locale = $locale;
    }

    /**
     * @param string $translationKey
     * @param array $parameters
     *
     * @return string
     */
    public function trans(string $translationKey, array $parameters = []): string
    {
        return empty($translationKey) ? "" : $this->translator->trans($translationKey, $parameters, $this->domain, $this->locale);
    }
}