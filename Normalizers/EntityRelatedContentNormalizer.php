<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

use Comitium5\ApiClientBundle\ApiClient\ResourcesTypes;
use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ActivityHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ArticleHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AssetHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\EntityHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\GalleryHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\LiveEventHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\PollHelper;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\ActivityNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\GalleryNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\LiveEventNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\Entities\PollNormalizer;
use Exception;

/**
 * Class EntityRelatedContentNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers
 */
class EntityRelatedContentNormalizer
{
    /**
     * @var ActivityHelper
     */
    private $activityHelper;

    /**
     * @var ActivityNormalizer|null
     */
    private $activityNormalizer;

    /**
     * @var ArticleHelper
     */
    private $articleHelper;

    /**
     * @var AssetHelper
     */
    private $assetHelper;

    /**
     * @var EntityHelper
     */
    private $helper;

    /**
     * @var GalleryHelper
     */
    private $galleryHelper;

    /**
     * @var PollHelper
     */
    private $pollHelper;

    /**
     * @var EntityNormalizer|null
     */
    private $articleNormalizer;

    /**
     * @var EntityNormalizer|null
     */
    private $assetNormalizer;

    /**
     * @var GalleryNormalizer|null
     */
    private $galleryNormalizer;

    /**
     * @var PollNormalizer|null
     */
    private $pollNormalizer;

    /**
     * @var PollHelper
     */
    private $liveEventHelper;

    /**
     * @var LiveEventNormalizer|null
     */
    private $liveEventNormalizer;

    /**
     * @param Client $api
     * @param ActivityNormalizer|null $activityNormalizer
     * @param EntityNormalizer|null $articleNormalizer
     * @param EntityNormalizer|null $assetNormalizer
     * @param GalleryNormalizer|null $galleryNormalizer
     * @param PollNormalizer|null $pollNormalizer
     * @param LiveEventNormalizer|null $liveEventNormalizer
     */
    public function __construct(
        Client              $api,
        ActivityNormalizer  $activityNormalizer = null,
        EntityNormalizer    $articleNormalizer = null,
        EntityNormalizer    $assetNormalizer = null,
        GalleryNormalizer   $galleryNormalizer = null,
        PollNormalizer      $pollNormalizer = null,
        LiveEventNormalizer $liveEventNormalizer = null
    )
    {
        $this->helper = new EntityHelper();
        $this->activityHelper = new ActivityHelper($api);
        $this->activityNormalizer = $activityNormalizer;
        $this->articleHelper = new ArticleHelper($api);
        $this->articleNormalizer = $articleNormalizer;
        $this->assetHelper = new AssetHelper($api);
        $this->assetNormalizer = $assetNormalizer;
        $this->galleryHelper = new GalleryHelper($api);
        $this->galleryNormalizer = $galleryNormalizer;
        $this->pollHelper = new PollHelper($api);
        $this->pollNormalizer = $pollNormalizer;
        $this->liveEventHelper = new LiveEventHelper($api);
        $this->liveEventNormalizer = $liveEventNormalizer;
    }

    /**
     * @param array $entity
     *
     * @return array
     * @throws Exception
     */
    public function normalize(array $entity): array
    {
        if (empty($entity)) {
            return [];
        }

        $entity['hasRelatedContent'] = false;
        $entity['hasRelatedActivities'] = false;
        $entity['relatedActivities'] = [];
        $entity['hasRelatedArticles'] = false;
        $entity['relatedArticles'] = [];
        $entity['hasRelatedAssets'] = false;
        $entity['relatedAssets'] = [];
        $entity['hasRelatedGalleries'] = false;
        $entity['relatedGalleries'] = [];
        $entity['hasRelatedPolls'] = false;
        $entity['relatedPolls'] = [];
        $entity['hasRelatedLiveEvents'] = false;
        $entity['relatedLiveEvents'] = [];
        if (empty($entity[EntityConstants::RELATED_CONTENT_FIELD_KEY])) {
            return $entity;
        }

        $relatedContents = $entity[EntityConstants::RELATED_CONTENT_FIELD_KEY];
        $relatedContentNormalized = [];

        foreach ($relatedContents as $relatedContent) {
            if (empty($relatedContent[EntityConstants::TYPE_FIELD_KEY])) {
                continue;
            }

            switch ($relatedContent[EntityConstants::TYPE_FIELD_KEY]) {
                case ResourcesTypes::ACTIVITY :
                    $relatedContent = $this->normalizeActivity($relatedContent);
                    if ($this->helper->isValid($relatedContent)) {
                        $entity['hasRelatedContent'] = true;
                        $entity['hasRelatedActivities'] = true;
                        $entity['relatedActivities'][] = $relatedContent;
                        $relatedContentNormalized[] = $relatedContent;
                    }
                    break;
                case ResourcesTypes::ARTICLE :
                    $relatedContent = $this->normalizeArticle($relatedContent);
                    if ($this->helper->isValid($relatedContent)) {
                        $entity['hasRelatedContent'] = true;
                        $entity['hasRelatedArticles'] = true;
                        $entity['relatedArticles'][] = $relatedContent;
                        $relatedContentNormalized[] = $relatedContent;
                    }
                    break;
                case ResourcesTypes::ASSET :
                    $relatedContent = $this->normalizeAsset($relatedContent);
                    if ($this->helper->isValid($relatedContent)) {
                        $entity['hasRelatedContent'] = true;
                        $entity['hasRelatedAssets'] = true;
                        $entity['relatedAssets'][] = $relatedContent;
                        $relatedContentNormalized[] = $relatedContent;
                    }
                    break;
                case ResourcesTypes::GALLERY :
                    $relatedContent = $this->normalizeGallery($relatedContent);
                    if ($this->helper->isValid($relatedContent)) {
                        $entity['hasRelatedContent'] = true;
                        $entity['hasRelatedGalleries'] = true;
                        $entity['relatedGalleries'][] = $relatedContent;
                        $relatedContentNormalized[] = $relatedContent;
                    }
                    break;
                case ResourcesTypes::POLL :
                    $relatedContent = $this->normalizePoll($relatedContent);
                    if ($this->helper->isValid($relatedContent)) {
                        $entity['hasRelatedContent'] = true;
                        $entity['hasRelatedPolls'] = true;
                        $entity['relatedPolls'][] = $relatedContent;
                        $relatedContentNormalized[] = $relatedContent;
                    }
                    break;
                case ResourcesTypes::LIVE_EVENT :
                    $relatedContent = $this->normalizeLiveEvent($relatedContent);
                    if ($this->helper->isValid($relatedContent)) {
                        $entity['hasRelatedContent'] = true;
                        $entity['hasRelatedLiveEvents'] = true;
                        $entity['relatedLiveEvents'][] = $relatedContent;
                        $relatedContentNormalized[] = $relatedContent;
                    }
                    break;
            }
        }

        $entity[EntityConstants::RELATED_CONTENT_FIELD_KEY] = $relatedContentNormalized;

        return $entity;
    }

    /**
     * @param $relatedContent
     *
     * @return array
     * @throws Exception
     */
    private function normalizeActivity($relatedContent): array
    {
        $activity = [];

        $activityId = 0;
        if (!empty($relatedContent[EntityConstants::ID_FIELD_KEY])) {
            $activityId = $relatedContent[EntityConstants::ID_FIELD_KEY];
        }

        if (!empty($activityId)) {
            $activity = $this->activityHelper->get($activityId);
            if (!$this->helper->isValid($activity)) {
                return [];
            }
            if (!empty($this->activityNormalizer)) {
                $activity = $this->activityNormalizer->normalize($activity);
            }
        }

        return $activity;
    }

    /**
     * @param $relatedContent
     *
     * @return array
     * @throws Exception
     */
    private function normalizeArticle($relatedContent): array
    {
        $article = [];

        $articleId = 0;
        if (!empty($relatedContent[EntityConstants::ID_FIELD_KEY])) {
            $articleId = $relatedContent[EntityConstants::ID_FIELD_KEY];
        }

        if (!empty($articleId)) {
            $article = $this->articleHelper->get($articleId);
            if (!$this->helper->isValid($article)) {
                return [];
            }
            if (!empty($this->articleNormalizer)) {
                $article = $this->articleNormalizer->normalize($article);
            }
        }

        return $article;
    }

    /**
     * @param $relatedContent
     *
     * @return array
     * @throws Exception
     */
    private function normalizeAsset($relatedContent): array
    {
        $asset = [];

        $assetId = 0;
        if (!empty($relatedContent[EntityConstants::ID_FIELD_KEY])) {
            $assetId = $relatedContent[EntityConstants::ID_FIELD_KEY];
        }

        if (!empty($assetId)) {
            $asset = $this->assetHelper->get($assetId);
            if (!$this->helper->isValid($asset)) {
                return [];
            }
            if (!empty($this->assetNormalizer)) {
                $asset = $this->assetNormalizer->normalize($asset);
            }
        }

        return $asset;
    }

    /**
     * @param array $relatedContent
     *
     * @return array
     * @throws Exception
     */
    private function normalizeGallery(array $relatedContent): array
    {
        $gallery = [];

        $galleryId = 0;
        if (!empty($relatedContent[EntityConstants::ID_FIELD_KEY])) {
            $galleryId = $relatedContent[EntityConstants::ID_FIELD_KEY];
        }

        if (!empty($galleryId)) {
            $gallery = $this->galleryHelper->get($galleryId);

            if (!$this->helper->isValid($gallery)) {
                return [];
            }
            if (!empty($this->galleryNormalizer)) {
                $gallery = $this->galleryNormalizer->normalize($gallery);
            }
        }

        return $gallery;
    }

    /**
     * @param array $relatedContent
     *
     * @return array
     * @throws Exception
     */
    private function normalizePoll(array $relatedContent): array
    {
        $poll = [];

        $pollId = 0;
        if (!empty($relatedContent[EntityConstants::ID_FIELD_KEY])) {
            $pollId = $relatedContent[EntityConstants::ID_FIELD_KEY];
        }

        if (!empty($pollId)) {
            $poll = $this->pollHelper->get($pollId);
            if (!$this->helper->isValid($poll)) {
                return [];
            }
            if (!empty($this->pollNormalizer)) {
                $poll = $this->pollNormalizer->normalize($poll);
            }
        }

        return $poll;
    }

    /**
     * @param array $relatedContent
     *
     * @return array
     * @throws Exception
     */
    private function normalizeLiveEvent(array $relatedContent): array
    {
        $liveEvent = [];

        $liveEventId = 0;
        if (!empty($relatedContent[EntityConstants::ID_FIELD_KEY])) {
            $liveEventId = $relatedContent[EntityConstants::ID_FIELD_KEY];
        }

        if (!empty($liveEventId)) {
            $liveEvent = $this->liveEventHelper->get($liveEventId);
            if (!$this->helper->isValid($liveEvent)) {
                return [];
            }
            if (!empty($this->liveEventNormalizer)) {
                $liveEvent = $this->liveEventNormalizer->normalize($liveEvent);
            }
        }

        return $liveEvent;
    }
}