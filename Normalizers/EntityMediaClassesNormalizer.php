<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

use Comitium5\ApiClientBundle\Normalizer\NormalizerInterface;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;

/**
 * Class EntityMediaClassesNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers
 */
class EntityMediaClassesNormalizer implements NormalizerInterface
{
    /**
     * @param array $entity
     *
     * @return array
     */
    public function normalize(array &$entity): array
    {
        if (!empty($entity)) {
            $mediaClasses = [];

            $hasActivity = $this->hasActivity($entity);
            if ($hasActivity) {
                $mediaClasses[] = EntityConstants::HAS_ACTIVITY;
            }

            $hasArticle = $this->hasArticle($entity);
            if ($hasArticle) {
                $mediaClasses[] = EntityConstants::HAS_ARTICLE;
            }

            $hasAsset = $this->hasAsset($entity);
            if ($hasAsset) {
                $mediaClasses[] = EntityConstants::HAS_ASSET;
            }

            $hasAudio = $this->hasAudio($entity);
            if ($hasAudio) {
                $mediaClasses[] = EntityConstants::HAS_AUDIO;
            }

            $categoryId = $this->getCategoryId($entity);
            if (!empty($categoryId)) {
                $mediaClasses[] = EntityConstants::HAS_CATEGORY . $categoryId;
            }

            $hasGallery = $this->hasGallery($entity);
            if ($hasGallery) {
                $mediaClasses[] = EntityConstants::HAS_GALLERY;
            }

            $hasImage = $this->hasImage($entity);
            if ($hasImage) {
                $mediaClasses[] = EntityConstants::HAS_IMAGE;
            } else {
                $mediaClasses[] = EntityConstants::HAS_NO_IMAGE;
            }

            $hasPoll = $this->hasPoll($entity);
            if ($hasPoll) {
                $mediaClasses[] = EntityConstants::HAS_POLL;
            }

            $hasVideo = $this->hasVideo($entity);
            if ($hasVideo) {
                $mediaClasses[] = EntityConstants::HAS_VIDEO;
            }

            $mediaClasses = implode(" ", $mediaClasses);
            $entity[EntityConstants::MEDIA_CLASSES_FIELD_KEY] = $mediaClasses;
        }

        return $entity;
    }

    /**
     * @param array $entity
     *
     * @return bool
     */
    private function hasActivity(array $entity): bool
    {
        if (empty($entity[EntityConstants::HAS_RELATED_ACTIVITIES_FIELD_KEY])) {
            return false;
        }

        return true;
    }

    /**
     * @param array $entity
     *
     * @return bool
     */
    private function hasAudio(array $entity): bool
    {
        if (empty($entity[EntityConstants::AUDIO_FIELD_KEY])) {
            return false;
        }

        return true;
    }

    /**
     * @param array $entity
     *
     * @return bool
     */
    private function hasArticle(array $entity): bool
    {
        if (empty($entity[EntityConstants::HAS_RELATED_ARTICLES_FIELD_KEY])) {
            return false;
        }

        return true;
    }

    /**
     * @param array $entity
     *
     * @return bool
     */
    private function hasAsset(array $entity): bool
    {
        if (empty($entity[EntityConstants::HAS_RELATED_ASSETS_FIELD_KEY])) {
            return false;
        }

        return true;
    }

    /**
     * @param array $entity
     *
     * @return int|void
     */
    private function getCategoryId(array $entity)
    {
        if (empty($entity[EntityConstants::CATEGORIES_FIELD_KEY])) {
            return 0;
        }

        $categoryId = 0;

        $categories = $entity[EntityConstants::CATEGORIES_FIELD_KEY];
        foreach ($categories as $category) {
            if (!empty($category[EntityConstants::ID_FIELD_KEY])) {
                $categoryId = $category[EntityConstants::ID_FIELD_KEY];
                break;
            }
        }

        return $categoryId;
    }

    /**
     * @param array $entity
     *
     * @return bool
     */
    private function hasGallery(array $entity): bool
    {
        if (empty($entity[EntityConstants::HAS_RELATED_GALLERIES_FIELD_KEY])) {
            return false;
        }

        return true;
    }

    /**
     * @param array $entity
     *
     * @return bool
     */
    private function hasImage(array $entity): bool
    {
        if (empty($entity[EntityConstants::IMAGE_FIELD_KEY])) {
            return false;
        }

        return true;
    }

    /**
     * @param array $entity
     *
     * @return bool
     */
    private function hasPoll(array $entity): bool
    {
        if (empty($entity[EntityConstants::HAS_RELATED_POLLS_FIELD_KEY])) {
            return false;
        }

        return true;
    }

    /**
     * @param array $entity
     *
     * @return bool
     */
    private function hasVideo(array $entity): bool
    {
        if (empty($entity[EntityConstants::VIDEO_FIELD_KEY])) {
            return false;
        }

        return true;
    }
}