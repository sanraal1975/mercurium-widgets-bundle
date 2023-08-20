<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;

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
        if (empty($entity)) {
            return false;
        }

        if (empty($entity[BundleConstants::SEARCHABLE_FIELD_KEY])) {
            return false;
        }

        return true;
    }

    /**
     * @param array $entity
     * @param int $categoryId
     *
     * @return bool
     */
    public function hasCategory(array $entity, int $categoryId): bool
    {
        if (empty($entity["categories"])) {
            return false;
        }

        if ($categoryId < 1) {
            return false;
        }

        foreach ($entity["categories"] as $category) {
            if ($category[BundleConstants::ID_FIELD_KEY] == $categoryId) {
                return true;
            }
        }

        return false;
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
        if (empty($entity[$field])) {
            return 0;
        }

        if ($charactersPerMinute < 1) {
            return 0;
        }

        $characters = $this->getFieldLength($entity[$field]);

        return $characters < ($charactersPerMinute / 2) ? 1 : (int)round($characters / $charactersPerMinute);
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
}