<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

/**
 * Class EntityHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class EntityHelper
{
    /**
     * @param array $entity
     * @param int $categoryId
     *
     * @return bool
     */
    public function hasCategory(array $entity, int $categoryId): bool
    {
        if (empty($entity['categories'])) {
            return false;
        }

        if ($categoryId < 1) {
            return false;
        }

        foreach ($entity['categories'] as $category) {
            if ($category['id'] == $categoryId) {
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
                '/\s+/',
                ' ',
                html_entity_decode(strip_tags($field))
            )
        );

        return mb_strlen($fieldStripped);
    }
}