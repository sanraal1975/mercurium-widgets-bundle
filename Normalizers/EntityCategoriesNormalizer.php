<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Abstracts\Interfaces\AbstractEntityNormalizerInterface;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\CategoryHelper;
use Exception;

/**
 * Class EntityCategoriesNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers
 */
class EntityCategoriesNormalizer implements AbstractEntityNormalizerInterface
{
    const EMPTY_FIELD = "EntityCategoriesNormalizer. field can not be empty";
    const QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO = "EntityCategoriesNormalizer. quantity must be equal or greater than 0";

    /**
     * @var string
     */
    private $field;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var CategoryHelper
     */
    private $helper;

    /**
     * @param Client $api
     * @param string $field
     * @param int $quantity
     * @throws Exception
     */
    public function __construct(Client $api, string $field = BundleConstants::CATEGORIES_FIELD_KEY, int $quantity = PHP_INT_MAX)
    {
        $this->field = $field;
        $this->quantity = $quantity;
        $this->helper = new CategoryHelper($api);

        $this->validate();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function validate()
    {
        if (empty($this->field)) {
            throw new Exception(self::EMPTY_FIELD);
        }

        if ($this->quantity < 0) {
            throw new Exception(self::QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO);
        }
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

        if (empty($entity[$this->field])) {
            return $entity;
        }

        if ($this->quantity === 0) {
            $entity[$this->field] = [];
            return $entity;
        }

        $normalizedCategories = [];
        foreach ($entity[$this->field] as $category) {
            $categoryId = empty($category[BundleConstants::ID_FIELD_KEY]) ? $category : $category[BundleConstants::ID_FIELD_KEY];
            $categoryId = (int)$categoryId;

            $categoryFromApi = $this->helper->get($categoryId);
            if (empty($categoryFromApi)) {
                continue;
            }

            $normalizedCategories[] = $categoryFromApi;

            if (count($normalizedCategories) === $this->quantity) {
                break;
            }
        }

        $entity[$this->field] = $normalizedCategories;

        return $entity;
    }
}