<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Helper;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Interfaces\BundleHomeMainArticleValueObjectInterface;
use Exception;

/**
 * Class BundleHomeMainArticleHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Helper
 */
class BundleHomeMainArticleHelper
{
    /**
     * @var BundleHomeMainArticleValueObjectInterface
     */
    private $valueObject;

    /**
     * @param BundleHomeMainArticleValueObjectInterface $valueObject
     */
    public function __construct(BundleHomeMainArticleValueObjectInterface $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getArticles(): array
    {
        $articlesIds = $this->valueObject->getArticlesIds();

        if (empty($articlesIds)) {
            return [];
        }

        $helper = new ArticleHelper($this->valueObject->getApi());

        return $helper->getByIds($articlesIds);
    }
}