<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

use Exception;

/**
 * Class EntityNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers
 */
class EntityNormalizer
{
    const EMPTY_NORMALIZERS_ARRAY = "EntityNormalizer::validate. normalizers array can not be empty.";

    /**
     * @var array
     */
    private $normalizers;

    /**
     * @param array $normalizers
     *
     * @return void
     * @throws Exception
     */
    public function __construct(array $normalizers)
    {
        $this->normalizers = $normalizers;

        $this->validate();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function validate()
    {
        if (empty($this->normalizers)) {
            throw new Exception(self::EMPTY_NORMALIZERS_ARRAY);
        }
    }

    /**
     * @param array $entity
     *
     * @return array
     */
    public function normalize(array $entity): array
    {
        if (empty(!$entity)) {
            foreach ($this->normalizers as $normalizer) {
                $entity = $normalizer->normalize($entity);
            }
        }
        return $entity;
    }
}