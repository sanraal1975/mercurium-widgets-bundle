<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Abstracts\Interfaces\AbstractEntityNormalizerInterface;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\TagHelper;
use Exception;

/**
 * Class EntityTagsNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers
 */
class EntityTagsNormalizer implements AbstractEntityNormalizerInterface
{
    const EMPTY_FIELD = "EntityTagsNormalizer. field can not be empty";
    const QUANTITY_MUST_BE_EQUAL_OR_GREATER_THAN_ZERO = "EntityTagsNormalizer. quantity must be equal or greater than 0";

    /**
     * @var string
     */
    private $field;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var TagHelper
     */
    private $helper;

    /**
     * @param Client $api
     * @param string $field
     * @param int $quantity
     * @throws Exception
     */
    public function __construct(Client $api, string $field = EntityConstants::TAGS_FIELD_KEY, int $quantity = PHP_INT_MAX)
    {
        $this->field = $field;
        $this->quantity = $quantity;
        $this->helper = new TagHelper($api);

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
        if (!empty($entity)) {
            if (!empty($entity[$this->field])) {
                if ($this->quantity === 0) {
                    $entity[$this->field] = [];
                } else {
                    $normalizedTags = [];
                    foreach ($entity[$this->field] as $tag) {
                        $tagId = empty($tag[EntityConstants::ID_FIELD_KEY]) ? $tag : $tag[EntityConstants::ID_FIELD_KEY];
                        $tagId = (int)$tagId;

                        $tagFromApi = $this->helper->get($tagId);
                        if (empty($tagFromApi)) {
                            continue;
                        }

                        $normalizedTags[] = $tagFromApi;

                        if (count($normalizedTags) === $this->quantity) {
                            break;
                        }
                    }

                    $entity[$this->field] = $normalizedTags;
                }
            }
        }
        return $entity;
    }

}