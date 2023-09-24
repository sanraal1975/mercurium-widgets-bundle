<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Helper;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\ValueObject\BundleHomeMainArticleValueObject;
use Exception;

/**
 * Class BundleHomeMainArticleHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Helper
 */
class BundleHomeMainArticleHelper
{
    /**
     * @param BundleHomeMainArticleValueObject $valueObject
     *
     * @return array
     * @throws Exception
     */
    public function getArticles(BundleHomeMainArticleValueObject $valueObject): array
    {
        $articlesIds = $valueObject->getArticlesIds();

        if (empty($articlesIds)) {
            return [];
        }

        $helper = new ArticleHelper($valueObject->getApi());

        return $helper->getByIds($articlesIds);
    }
}