<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

use Comitium5\ApiClientBundle\Normalizer\NormalizerInterface;
use Comitium5\ApiClientBundle\Utils\FieldsUtils;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;

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
    public function __construct(array $fields, string $field = EntityConstants::FIELDS_FIELD_KEY)
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
        if (!empty($entity[EntityConstants::TYPE_FIELD_KEY][EntityConstants::ID_FIELD_KEY])) {
            $entityType = $entity[EntityConstants::TYPE_FIELD_KEY][EntityConstants::ID_FIELD_KEY];
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

        foreach ($fields as $key => $value) {
            $fieldName = $this->getFieldName($value);
            $fieldType = $this->getFieldType($value);
            $valueType = $this->getFieldValueType($value);
            if ($fieldType === "loop") {
                $entity[$key] = FieldsUtils::loopField($fieldName, $values);
            } else {
                $entity[$key] = FieldsUtils::fieldValue($fieldName, $values);
                settype($entity[$key], $valueType);
            }
        }

        return $entity;
    }

    /**
     * @param $field
     *
     * @return mixed|string
     */
    private function getFieldName($field)
    {
        $result = "";

        if (is_string($field)) {
            $result = $field;
        } else {
            if (is_array($field)) {
                if (!empty($field['field'])) {
                    $result = $field['field'];
                }
            }
        }

        return $result;
    }

    /**
     * @param $field
     *
     * @return string
     */
    private function getFieldType($field): string
    {
        $result = "value";

        if (!empty($field['type'])) {
            $result = $field['type'];
        }

        return $result;

    }

    /**
     * @param $field
     *
     * @return string
     */
    private function getFieldValueType($field): string
    {
        $result = "string";

        if (!empty($field['valueType'])) {
            $result = $field['valueType'];
        }

        return $result;
    }
}