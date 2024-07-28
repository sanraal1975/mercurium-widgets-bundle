<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Helper;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\EntityHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\PageHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Interfaces\BundleHeaderRenderLoggedContentValueObjectInterface;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\ValueObject\BundleHeaderRenderLoggedContentValueObject;
use Exception;

/**
 * Class BundleHeaderRenderLoggedContentHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Helper
 */
class BundleHeaderRenderLoggedContentHelper
{
    /**
     * @var BundleHeaderRenderLoggedContentValueObject
     */
    private $valueObject;

    /**
     * @param BundleHeaderRenderLoggedContentValueObject $valueObject
     */
    public function __construct(BundleHeaderRenderLoggedContentValueObjectInterface $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    /**
     * @param int $pageId
     *
     * @return array
     * @throws Exception
     */
    public function getPage(int $pageId): array
    {
        $page = [];

        if (!empty($pageId)) {
            $api = $this->valueObject->getApi();
            $helper = new PageHelper($api);
            $page = $helper->get($pageId);
            $helper = new EntityHelper();
            $page = ($helper->isValid($page)) ? $page : [];
        }

        return $page;
    }
}