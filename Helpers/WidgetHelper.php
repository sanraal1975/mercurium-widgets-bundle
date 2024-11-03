<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers;

use Comitium5\ApiClientBundle\ApiClient\ResourcesTypes;
use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ActivityHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AssetHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AuthorHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\CategoryHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ContactHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\EntityHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\GalleryHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ImageHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\LiveEventHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\MenuHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\PageHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\PollHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\SubscriptionHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\TagHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\VideoHelper;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\ApiRequestValueObject;
use Exception;

/**
 * Class WidgetHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers
 */
class WidgetHelper
{
    const MENU_CODE = 900;
    const SUBSCRIPTION_CODE = 901;

    /**
     * @var Client
     */
    private $api;

    /**
     * @param Client $api
     */
    public function __construct(Client $api)
    {
        $this->api = $api;
    }

    /**
     * @param ApiRequestValueObject $valueObject
     *
     * @return array
     * @throws Exception
     */
    public function getArticlesBy(ApiRequestValueObject $valueObject): array
    {
        return $this->getEntitiesBy($valueObject, ResourcesTypes::ARTICLE_CODE);
    }

    /**
     * @param string $articlesIds
     *
     * @return array
     * @throws Exception
     */
    public function getArticlesByIds(string $articlesIds): array
    {
        $articles = [];

        if (!empty($articlesIds)) {
            $articles = $this->getEntitiesByIds($articlesIds, ResourcesTypes::ARTICLE_CODE);
        }

        return $articles;
    }

    /**
     * @param int $galleryId
     *
     * @return array
     * @throws Exception
     */
    public function getGallery(int $galleryId): array
    {
        $gallery = [];

        if ($galleryId > 0) {
            $gallery = $this->getEntity($galleryId, ResourcesTypes::GALLERY_CODE);
        }

        return $gallery;
    }

    /**
     * @param int $imageId
     *
     * @return array
     * @throws Exception
     */
    public function getImage(int $imageId): array
    {
        $image = [];
        if ($imageId > 0) {
            $image = $this->getEntity($imageId, ResourcesTypes::ASSET_IMAGE_CODE);
        }

        return $image;
    }

    /**
     * @param int $menuId
     *
     * @return array
     * @throws Exception
     */
    public function getMenu(int $menuId): array
    {
        $menu = [];

        if ($menuId > 0) {
            $menu = $this->getEntity($menuId, self::MENU_CODE);
        }

        return $menu;
    }

    /**
     * @param array $menu
     *
     * @return array|false|mixed
     */
    public function getMenuItems(array $menu)
    {
        $items = [];

        if (!empty($menu)) {
            $helper = new EntityHelper();
            $items = $helper->getField($menu, EntityConstants::ITEMS_FIELD_KEY);
        }

        return $items;
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

        if ($pageId > 0) {
            $page = $this->getEntity($pageId, ResourcesTypes::PAGE_CODE);
        }

        return $page;
    }

    /**
     * @param int $entityId
     * @param int $entityType
     *
     * @return array
     * @throws Exception
     */
    private function getEntity(int $entityId, int $entityType): array
    {
        $entity = [];

        if ($entityId > 0) {
            $helper = $this->getHelper($entityType);
            if ($helper !== null) {
                $entity = $helper->get($entityId);

                $entityHelper = new EntityHelper();
                $entity = ($entityHelper->isValid($entity)) ? $entity : [];
            }
        }

        return $entity;
    }

    /**
     * @param ApiRequestValueObject $valueObject
     * @param int $entityType
     *
     * @return array
     * @throws Exception
     */
    private function getEntitiesBy(ApiRequestValueObject $valueObject, int $entityType): array
    {
        $entities = [];

        $helper = $this->getHelper($entityType);
        if ($helper !== null) {
            $apiParameters = $valueObject->getParameters();
            $entitiesFromApi = $helper->getBy($apiParameters);
            if (!empty($entitiesFromApi)) {
                $entityHelper = new EntityHelper();
                foreach ($entitiesFromApi as $entity) {
                    $isValidEntity = $entityHelper->isValid($entity);
                    if ($isValidEntity) {
                        $entities[] = $entity;
                    }
                }
            }
        }

        return $entities;
    }

    /**
     * @param string $entitiesIds
     * @param int $entityType
     *
     * @return array
     * @throws Exception
     */
    private function getEntitiesByIds(string $entitiesIds, int $entityType): array
    {
        $entities = [];

        if (!empty($entitiesIds)) {
            $helper = $this->getHelper($entityType);
            if ($helper !== null) {
                $entitiesFromApi = $helper->getByIds($entitiesIds);
                if (!empty($entitiesFromApi)) {
                    $entityHelper = new EntityHelper();
                    foreach ($entitiesFromApi as $entity) {
                        $isValidEntity = $entityHelper->isValid($entity);
                        if ($isValidEntity) {
                            $entities[] = $entity;
                        }
                    }
                }
            }
        }

        return $entities;
    }

    /**
     * @param int $entityType
     *
     * @return ActivityHelper|ArticleHelper|AssetHelper|AuthorHelper|CategoryHelper|ContactHelper|GalleryHelper|LiveEventHelper|MenuHelper|PageHelper|PollHelper|SubscriptionHelper|TagHelper|null
     */
    private function getHelper(int $entityType)
    {
        $helper = null;

        switch ($entityType) {
            case ResourcesTypes::ACTIVITY_CODE :
                $helper = new ActivityHelper($this->api);
                break;
            case ResourcesTypes::ARTICLE_CODE :
                $helper = new ArticleHelper($this->api);
                break;
            case ResourcesTypes::ASSET_IMAGE_CODE :
                $helper = new ImageHelper($this->api);
                break;
            case ResourcesTypes::ASSET_VIDEO_CODE :
                $helper = new VideoHelper($this->api);
                break;
            case ResourcesTypes::ASSET_CODE :
            case ResourcesTypes::ASSET_SOUND_CODE :
            case ResourcesTypes::ASSET_DOCUMENT_CODE :
                $helper = new AssetHelper($this->api);
                break;
            case ResourcesTypes::AUTHOR_CODE :
                $helper = new AuthorHelper($this->api);
                break;
            case ResourcesTypes::CATEGORY_CODE :
                $helper = new CategoryHelper($this->api);
                break;
            case ResourcesTypes::CONTACT_CODE :
                $helper = new ContactHelper($this->api);
                break;
            case ResourcesTypes::GALLERY_CODE :
                $helper = new GalleryHelper($this->api);
                break;
            case ResourcesTypes::LIVE_EVENT_CODE :
                $helper = new LiveEventHelper($this->api);
                break;
            case self::MENU_CODE:
                $helper = new MenuHelper($this->api);
                break;
            case ResourcesTypes::PAGE_CODE :
                $helper = new PageHelper($this->api);
                break;
            case ResourcesTypes::POLL_CODE :
                $helper = new PollHelper($this->api);
                break;
            case self::SUBSCRIPTION_CODE :
                $helper = new SubscriptionHelper($this->api);
                break;
            case ResourcesTypes::TAG_CODE :
                $helper = new TagHelper($this->api);
                break;
        }

        return $helper;
    }
}