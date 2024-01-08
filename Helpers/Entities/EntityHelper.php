<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;

/**
 * Class EntityHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class EntityHelper
{
    /**
     * @param array $entity
     *
     * @return bool
     */
    public function isValid(array $entity): bool
    {
        $result = false;

        if (!empty($entity)) {
            if (!empty($entity[EntityConstants::SEARCHABLE_FIELD_KEY])) {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * @param array $entity
     * @param int $categoryId
     *
     * @return bool
     */
    public function hasCategory(array $entity, int $categoryId): bool
    {
        $result = false;

        if (!empty($entity[EntityConstants::CATEGORIES_FIELD_KEY])) {
            if ($categoryId > 0) {
                foreach ($entity[EntityConstants::CATEGORIES_FIELD_KEY] as $category) {
                    if ($category[EntityConstants::ID_FIELD_KEY] == $categoryId) {
                        $result = true;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @param array $entity
     * @param string $field
     * @param int $charactersPerMinute
     *
     * @return int
     */
    public function getFieldReadingTime(array $entity, string $field, int $charactersPerMinute): int
    {
        $result = 0;

        if (!empty($entity[$field])) {
            if ($charactersPerMinute > 0) {
                $characters = $this->getFieldLength($entity[$field]);

                $result = $characters < ($charactersPerMinute / 2) ? 1 : (int)round($characters / $charactersPerMinute);
            }
        }

        return $result;
    }

    /**
     * @param string $field
     *
     * @return int
     */
    public function getFieldLength(string $field): int
    {
        if (empty($field)) {
            return 0;
        }

        $fieldStripped = trim(
            preg_replace(
                "/\s+/",
                " ",
                html_entity_decode(strip_tags($field))
            )
        );

        return mb_strlen($fieldStripped);
    }

    /**
     * @param string $field
     *
     * @return string
     */
    public function clearEmbedScripts(string $field): string
    {
        if (empty($field)) {
            return "";
        }

        $field = preg_replace('/(<script.+?src="https:\/\/platform\.twitter.*?".*?><\/script>)/', "", $field);
        $field = preg_replace('/(<script.+?src="\/\/www\.instagram\.com\/embed.*?".*?><\/script>)/', "", $field);
        $field = preg_replace('/(<script.+?src="https:\/\/www.tiktok.com\/embed.*?".*?><\/script>)/', "", $field);
        $field = str_replace(' src="https://www.facebook.com/plugins/post.php?', ' loading="lazy" src="https://www.facebook.com/plugins/post.php?', $field);

        return self::replaceYoutubeCode($field);
    }

    /**
     * @param string $field
     *
     * @return string
     */
    public function replaceYoutubeCode(string $field): string
    {
        $matched = preg_match('/(<iframe.*?src=".*?youtube.com\/embed\/(.+?)".*?><\/iframe>)/', $field, $matches);
        if ($matched) {
            $field = str_replace($matches[1], '<div class="youtube-player" data-id="' . $matches[2] . '"></div>', $field);
        }
        return $field;
    }

    /**
     * @param array $entity
     * @param string $field
     *
     * @return false|mixed
     */
    public function getField(array $entity, string $field)
    {
        return empty($entity[$field]) ? false : $entity[$field];
    }

    /**
     * @param array $entity
     *
     * @return false|mixed
     */
    public function getPermalink(array $entity)
    {
        return $this->getField($entity, EntityConstants::PERMALINK_FIELD_KEY);
    }
}