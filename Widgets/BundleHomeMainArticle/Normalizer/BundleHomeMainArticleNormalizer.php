<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Normalizer;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\EntityHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\ValueObject\BundleHomeMainArticleValueObject;

/**
 * Class BundleHomeMainArticleNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHomeMainArticle\Normalizer
 */
class BundleHomeMainArticleNormalizer
{
    /**
     * @var BundleHomeMainArticleValueObject
     */
    private $valueObject;

    /**
     * @param BundleHomeMainArticleValueObject $valueObject
     */
    public function __construct(BundleHomeMainArticleValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    /**
     * @param array $articles
     *
     * @return array
     */
    public function normalize(array $articles): array
    {
        if (empty($articles)) {
            return [];
        }

        $helper = new EntityHelper();

        $normalizer = $this->valueObject->getNormalizer();

        $normalizedArticles = [];

        foreach ($articles as $article) {
            if (!$helper->isValid($article)) {
                continue;
            }

            $article = $normalizer->normalize($article);

            if (!$helper->isValid($article)) {
                continue;
            }

            $normalizedArticles[] = $article;
        }

        return $normalizedArticles;
    }
}