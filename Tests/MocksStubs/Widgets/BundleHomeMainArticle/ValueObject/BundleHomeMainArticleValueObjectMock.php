<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleHomeMainArticle\ValueObject;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Interfaces\BundleHomeMainArticleValueObjectInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * Class BundleHomeMainArticleValueObjectMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Widgets\BundleHomeMainArticle\ValueObject
 */
class BundleHomeMainArticleValueObjectMock implements BundleHomeMainArticleValueObjectInterface
{
    /**
     * @var Client
     */
    protected $api;

    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $subSiteAcronym;

    /**
     * @var string
     */
    private $translationGroup;

    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $articlesIds;

    /**
     * @var bool
     */
    private $showSubtitle;

    /**
     * @var bool
     */
    private $showImage;

    /**
     * @var bool
     */
    private $showRelatedContent;

    /**
     * @var bool
     */
    private $showNumComments;

    /**
     * @var bool
     */
    private $showSponsor;

    /**
     * @param Client $api
     * @param string $locale
     * @param string $subSiteAcronym
     * @param string $translationGroup
     * @param string $format
     * @param string $articlesIds
     * @param bool $showSubtitle
     * @param bool $showImage
     * @param bool $showRelatedContent
     * @param bool $showNumComments
     * @param bool $showSponsor
     * @param string $bannerId
     */
    public function __construct(
        Client     $api,
        string     $locale,
        string     $subSiteAcronym,
        string     $translationGroup,
        string     $format,
        string     $articlesIds,
        bool       $showSubtitle,
        bool       $showImage,
        bool       $showRelatedContent,
        bool       $showNumComments,
        bool       $showSponsor
    )
    {
        $this->api = $api;
        $this->locale = $locale;
        $this->subSiteAcronym = $subSiteAcronym;
        $this->translationGroup = $translationGroup;
        $this->format = $format;
        $this->articlesIds = $articlesIds;
        $this->showSubtitle = $showSubtitle;
        $this->showImage = $showImage;
        $this->showRelatedContent = $showRelatedContent;
        $this->showNumComments = $showNumComments;
        $this->showSponsor = $showSponsor;
    }

    /**
     * @return Client
     */
    public function getApi(): Client
    {
        return $this->api;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getSubSiteAcronym(): string
    {
        return $this->subSiteAcronym;
    }

    /**
     * @return string
     */
    public function getTranslationGroup(): string
    {
        return $this->translationGroup;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getArticlesIds(): string
    {
        return $this->articlesIds;
    }

    /**
     * @return bool
     */
    public function getShowSubtitle(): bool
    {
        return $this->showSubtitle;
    }

    /**
     * @return bool
     */
    public function getShowImage(): bool
    {
        return $this->showImage;
    }

    /**
     * @return bool
     */
    public function getShowRelatedContent(): bool
    {
        return $this->showRelatedContent;
    }

    /**
     * @return bool
     */
    public function getShowNumComments(): bool
    {
        return $this->showNumComments;
    }

    /**
     * @return bool
     */
    public function getShowSponsor(): bool
    {
        return $this->showSponsor;
    }
}