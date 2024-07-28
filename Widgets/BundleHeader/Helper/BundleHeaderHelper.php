<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Helper;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\EntityHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\MenuHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\PageHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Interfaces\BundleHeaderValueObjectInterface;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\ValueObject\BundleHeaderValueObject;
use Exception;

/**
 * Class BundleHeaderHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Helper
 */
class BundleHeaderHelper
{
    /**
     * @var BundleHeaderValueObject
     */
    private $valueObject;

    /**
     * @param BundleHeaderValueObject $valueObject
     */
    public function __construct(BundleHeaderValueObjectInterface $valueObject)
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

    /**
     * @return array
     * @throws Exception
     */
    public function getNavItems(): array
    {
        $navItems = [];
        $menuId = $this->valueObject->getNavItemsMenuId();
        if (!empty($menuId)) {
            $api = $this->valueObject->getApi();
            $helper = new MenuHelper($api);
            $menu = $helper->get($menuId);

            $navItems = empty($menu['items']) ? [] : $menu['items'];
        }
        return $navItems;
    }
}