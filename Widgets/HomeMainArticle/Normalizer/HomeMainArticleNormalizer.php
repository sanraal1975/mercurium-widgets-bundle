<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\HomeMainArticle\Normalizer;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\EntityHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\HomeMainArticle\ValueObject\HomeMainArticleValueObject;

/**
 * Class HomeMainArticleNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\HomeMainArticle\Normalizer
 */
class HomeMainArticleNormalizer
{
    /**
     * @var HomeMainArticleValueObject
     */
    private $valueObject;

    /**
     * @param HomeMainArticleValueObject $valueObject
     */
    public function __construct(HomeMainArticleValueObject $valueObject)
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