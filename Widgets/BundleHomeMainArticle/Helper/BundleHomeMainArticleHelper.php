<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Helper;

use Comitium5\MercuriumWidgetsBundle\Helpers\WidgetHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Interfaces\BundleHomeMainArticleValueObjectInterface;
use Exception;

/**
 * Class BundleHomeMainArticleHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHomeMainArticle\Helper
 */
class BundleHomeMainArticleHelper extends WidgetHelper
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
        $api = $valueObject->getApi();
        parent::__construct($api);

        $this->valueObject = $valueObject;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getArticles(): array
    {
        $articles = [];

        $articlesIds = $this->valueObject->getArticlesIds();

        if (!empty($articlesIds)) {
            $articles = $this->getArticlesByIds($articlesIds);
        }

        return $articles;
    }
}