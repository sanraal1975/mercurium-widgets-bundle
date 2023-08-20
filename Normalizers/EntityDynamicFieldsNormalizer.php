<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

use Comitium5\ApiClientBundle\Normalizer\NormalizerInterface;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;

/**
 * Class EntityDynamicFieldsNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers
 */
class EntityDynamicFieldsNormalizer implements NormalizerInterface
{
    /**
     * @var array
     */
    private $fields;

    /**
     * @var string
     */
    private $field;

    /**
     * @param array $fields
     * @param string $field
     */
    public function __construct(array $fields, string $field = BundleConstants::FIELDS_FIELD_KEY)
    {
        $this->fields = $fields;
        $this->field = $field;
    }

    /**
     * @param array $entity
     *
     * @return array
     */
    public function normalize(array &$entity): array
    {
        if (empty($entity)) {
            return [];
        }

        $fields = $this->fields;

        if (empty($fields)) {
            return $entity;
        }

        $field = $this->field;

        if (empty($field)) {
            return $entity;
        }

        if (empty($entity[$field])) {
            return $entity;
        }

        $entityType = null;
        if (!empty($entity[BundleConstants::TYPE_FIELD_KEY][BundleConstants::ID_FIELD_KEY])) {
            $entityType = $entity[BundleConstants::TYPE_FIELD_KEY][BundleConstants::ID_FIELD_KEY];
        }

        $resourceType = null;
        if (!empty($entity['resourceType'])) {
            $resourceType = $entity['resourceType'];
        }

        $fields = [];
        if (empty($entityType)) {
            if (!empty($this->fields[$resourceType])) {
                $fields = $this->fields[$resourceType];
            }
        } else {
            if (!empty($this->fields[$resourceType][$entityType])) {
                $fields = $this->fields[$resourceType][$entityType];
            }
        }

        if (empty($fields)) {
            return $entity;
        }

        $values = $entity[$field];

//        echo PHP_EOL;
//        var_dump(__METHOD__." : ".__LINE__);
//        echo PHP_EOL;
//        var_dump($entity);
//        echo PHP_EOL;
//        var_dump($entityType);
//        echo PHP_EOL;

        return $entity;
    }
}