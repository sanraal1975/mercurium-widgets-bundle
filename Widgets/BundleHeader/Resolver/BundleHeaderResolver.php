<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Resolver;

use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\EntityHelper;
use Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\SiteNavigationRichSnippetsResolver;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Helper\BundleHeaderHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Interfaces\BundleHeaderValueObjectInterface;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\ValueObject\BundleHeaderValueObject;
use Exception;

/**
 * Class BundleHeaderResolver
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Resolver
 */
class BundleHeaderResolver
{
    /**
     * @var BundleHeaderHelper
     */
    private $helper;

    /**
     * @var BundleHeaderValueObject
     */
    private $valueObject;

    /**
     * @param BundleHeaderValueObjectInterface $valueObject
     */
    public function __construct(BundleHeaderValueObjectInterface $valueObject)
    {
        $this->helper = new BundleHeaderHelper($valueObject);
        $this->valueObject = $valueObject;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function resolve(): array
    {
        $locales = $this->valueObject->getLocales();
        $localeUrls = $this->resolveLocaleUrls();
        $isHome = $this->resolveIsHome();
        $searchPage = $this->resolveSearchPage();
        $registerPage = $this->resolveRegisterPage();
        $loginPage = $this->resolveLoginPage();
        $navItems = $this->resolveNavItems();
        $richSnippets = $this->resolveRichSnippets($navItems);

        return [
            "locales" => $locales,
            "localeUrls" => $localeUrls,
            "isHome" => $isHome,
            "searchPage" => $searchPage,
            "registerPage" => $registerPage,
            "loginPage" => $loginPage,
            "navItems" => $navItems,
            "richSnippets" => $richSnippets,
        ];
    }

    /**
     * @return array|mixed
     */
    private function resolveLocaleUrls()
    {
        $urls = [];
        $locales = $this->valueObject->getLocales();
        if (count($locales) > 1) {
            $entity = $this->valueObject->getEntityFromRequest();
            if (!empty($entity)) {
                $helper = new EntityHelper();
                $urls = $helper->getPermalinks($entity);
            } else {
                $page = $this->valueObject->getPageFromRequest();
                if (!empty($page)) {
                    $helper = new EntityHelper();
                    $urls = $helper->getPermalinks($page);
                }
            }
        }

        return $urls;
    }

    /**
     * @return bool
     */
    private function resolveIsHome(): bool
    {
        $isHome = false;
        $page = $this->valueObject->getPageFromRequest();
        if (!empty($page)) {
            $helper = new EntityHelper();
            $pageId = $helper->getId($page);
            if (!empty($pageId)) {
                $homePageId = $this->valueObject->getHomePageId();
                $isHome = ($pageId == $homePageId);
            }
        }

        return $isHome;
    }

    /**
     * @return array
     * @throws Exception
     */
    private function resolveSearchPage(): array
    {
        $page = [];
        $pageId = $this->valueObject->getSearchPageId();
        if ($pageId > 0) {
            $page = $this->helper->getPage($pageId);
        }

        return $page;
    }

    /**
     * @return array
     * @throws Exception
     */
    private function resolveRegisterPage(): array
    {
        $page = [];
        $pageId = $this->valueObject->getRegisterPageId();
        if ($pageId > 0) {
            $page = $this->helper->getPage($pageId);
        }

        return $page;
    }

    /**
     * @return array
     * @throws Exception
     */
    private function resolveLoginPage(): array
    {
        $page = [];
        $pageId = $this->valueObject->getLoginPageId();
        if ($pageId > 0) {
            $page = $this->helper->getPage($pageId);
        }

        return $page;
    }

    /**
     * @return array
     * @throws Exception
     */
    private function resolveNavItems(): array
    {
        $navItems = [];
        $menuId = $this->valueObject->getNavItemsMenuId();
        if ($menuId > 0) {
            $menu = $this->helper->getMenu($menuId);
            $navItems = $this->helper->getMenuItems($menu);
        }

        return $navItems;
    }

    /**
     * @param array $items
     *
     * @return string
     */
    private function resolveRichSnippets(array $items): string
    {
        $richSnippets = "";
        if (!empty($items)) {
            $resolver = new SiteNavigationRichSnippetsResolver($this->valueObject->getSiteName(), $this->valueObject->getSiteUrl());
            $richSnippets = $resolver->resolve($items);
        }

        return $richSnippets;
    }
}