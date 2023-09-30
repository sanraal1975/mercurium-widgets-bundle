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
     * @return BundleHomeMainArticleValueObject
     */
    public function getValueObject(): BundleHomeMainArticleValueObject
    {
        return $this->valueObject;
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