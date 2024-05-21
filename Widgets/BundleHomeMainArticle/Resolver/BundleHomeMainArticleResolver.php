<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Resolver;

use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Helper\BundleHomeMainArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Normalizer\BundleHomeMainArticleNormalizer;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\ValueObject\BundleHomeMainArticleValueObject;
use Exception;

/**
 * Class BundleHomeMainArticleResolver
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle
 */
class BundleHomeMainArticleResolver
{
    /**
     * @var BundleHomeMainArticleValueObject
     */
    private $valueObject;

    /**
     * @var BundleHomeMainArticleHelper
     */
    private $helper;

    /**
     * @var BundleHomeMainArticleNormalizer
     */
    private $normalizer;

    /**
     * @param BundleHomeMainArticleValueObject $valueObject
     * @param EntityNormalizer $normalizer
     */
    public function __construct(BundleHomeMainArticleValueObject $valueObject, EntityNormalizer $normalizer)
    {
        $this->valueObject = $valueObject;
        $this->helper = new BundleHomeMainArticleHelper($valueObject);
        $this->normalizer = new BundleHomeMainArticleNormalizer($normalizer);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function resolve(): array
    {
        $articles = $this->resolveArticles();
        $locale = $this->valueObject->getLocale();
        $translationGroup = $this->valueObject->getTranslationGroup();
        $subSiteAcronym = $this->valueObject->getSubSiteAcronym();
        $format = $this->valueObject->getFormat();
        $showImage = $this->valueObject->getShowImage();
        $showNumComments = $this->valueObject->getShowNumComments();
        $showRelatedContent = $this->valueObject->getShowRelatedContent();
        $showSponsor = $this->valueObject->getShowSponsor();
        $showSubtitle = $this->valueObject->getShowSubtitle();

        return [
            "articles" => $articles,
            "format" => $format,
            "locale" => $locale,
            "translationGroup" => $translationGroup,
            "subSiteAcronym" => $subSiteAcronym,
            "showImage" => $showImage,
            "showNumComments" => $showNumComments,
            "showRelatedContent" => $showRelatedContent,
            "showSponsor" => $showSponsor,
            "showSubtitle" => $showSubtitle,
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    private function resolveArticles(): array
    {
        $articles = $this->helper->getArticles();

        return $this->normalizer->normalize($articles);
    }
}