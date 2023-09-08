<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers\Entities;

use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Exception;

/**
 * Class ActivityNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers\Entities
 */
class ActivityNormalizer
{
    /**
     * @var EntityNormalizer
     */
    private $activityNormalizer;

    /**
     * @var EntityNormalizer
     */
    private $imageNormalizer;

    /**
     * @param EntityNormalizer|null $activityNormalizer
     * @param EntityNormalizer|null $imageNormalizer
     */
    public function __construct(EntityNormalizer $activityNormalizer = null, EntityNormalizer $imageNormalizer = null)
    {
        $this->activityNormalizer = $activityNormalizer;
        $this->imageNormalizer = $imageNormalizer;
    }

    /**
     * @param array $entity
     *
     * @return array
     * @throws Exception
     */
    public function normalize(array &$entity): array
    {
        if (!empty($entity)) {
            if ($this->activityNormalizer != null) {
                $entity = $this->activityNormalizer->normalize($entity);
            }

            if ($this->imageNormalizer != null) {
                $asset = [];
                if (!empty($entity[EntityConstants::ASSET_FIELD_KEY])) {
                    $asset = $entity[EntityConstants::ASSET_FIELD_KEY];
                    $asset = $this->imageNormalizer->normalize($asset);
                }
                $entity[EntityConstants::ASSET_FIELD_KEY] = $asset;
            }
        }

        return $entity;
    }
}