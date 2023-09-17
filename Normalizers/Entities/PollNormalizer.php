<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers\Entities;

use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Exception;

/**
 * Class PollNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers\Entities
 */
class PollNormalizer
{
    /**
     * @var EntityNormalizer
     */
    private $pollNormalizer;

    /**
     * @var EntityNormalizer
     */
    private $imageNormalizer;

    /**
     * @param EntityNormalizer|null $pollNormalizer
     * @param EntityNormalizer|null $imageNormalizer
     */
    public function __construct(EntityNormalizer $pollNormalizer = null, EntityNormalizer $imageNormalizer = null)
    {
        $this->pollNormalizer = $pollNormalizer;
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
            if ($this->pollNormalizer != null) {
                $entity = $this->pollNormalizer->normalize($entity);
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

