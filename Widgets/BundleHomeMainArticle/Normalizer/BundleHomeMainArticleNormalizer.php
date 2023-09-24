<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Normalizer;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\EntityHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;

/**
 * Class BundleHomeMainArticleNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Widgets\BundleHomeMainArticle\Normalizer
 */
class BundleHomeMainArticleNormalizer
{
    /**
     * @var EntityNormalizer
     */
    private $normalizer;

    /**
     * @param EntityNormalizer $normalizer
     */
    public function __construct(EntityNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
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

        $normalizedArticles = [];

        foreach ($articles as $article) {
            if (!$helper->isValid($article)) {
                continue;
            }

            $article = $this->normalizer->normalize($article);

            if (!$helper->isValid($article)) {
                continue;
            }

            $normalizedArticles[] = $article;
        }

        return $normalizedArticles;
    }
}