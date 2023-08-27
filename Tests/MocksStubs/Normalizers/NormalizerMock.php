<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers;

use Comitium5\MercuriumWidgetsBundle\Abstracts\Interfaces\AbstractEntityNormalizerInterface;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;

/**
 * Class NormalizerMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Normalizers
 */
class NormalizerMock implements AbstractEntityNormalizerInterface
{
    /**
     * @param array $entity
     *
     * @return array
     */
    public function normalize(array $entity): array
    {
        if (!empty($entity[EntityConstants::ID_FIELD_KEY])) {
            if ($entity[EntityConstants::ID_FIELD_KEY] == TestHelper::ENTITY_ID_TO_RETURN_EMPTY) {
                return [];
            }
        }
        return $entity;
    }
}