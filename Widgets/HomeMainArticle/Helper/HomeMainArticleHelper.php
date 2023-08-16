<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\HomeMainArticle\Helper;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\HomeMainArticle\ValueObject\HomeMainArticleValueObject;
use Exception;

/**
 * Class HomeMainArticleHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\HomeMainArticle\Helper
 */
class HomeMainArticleHelper
{
    /**
     * @param HomeMainArticleValueObject $valueObject
     *
     * @return array
     * @throws Exception
     */
    public function getArticles(HomeMainArticleValueObject $valueObject): array
    {
        $articlesIds = $valueObject->getArticlesIds();

        if (empty($articlesIds)) {
            return [];
        }

        $helper = new ArticleHelper($valueObject->getApi());

        return $helper->getByIds($articlesIds);
    }
}