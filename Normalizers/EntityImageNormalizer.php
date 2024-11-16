<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Abstracts\Interfaces\AbstractEntityNormalizerInterface;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\EntityHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ImageHelper;
use Exception;

/**
 * Class EntityImageNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers
 */
class EntityImageNormalizer implements AbstractEntityNormalizerInterface
{
    const NON_NUMERIC_ASSET_ID = "EntityImageNormalizer::normalize. non numeric asset id.";

    const EMPTY_FIELD = "EntityImageNormalizer::validate. field can not be empty.";

    /**
     * @var ImageHelper
     */
    private $helper;

    /**
     * @var string
     */
    private $field;

    /**
     * @param Client $api
     * @param string $field
     * @throws Exception
     */
    public function __construct(Client $api, string $field)
    {
        $this->helper = new ImageHelper($api);
        $this->field = $field;

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
    }

    /**
     * @param array $entity
     *
     * @return array
     * @throws Exception
     */
    public function normalize(array $entity, bool $dump=false): array
    {
        if (!empty($entity)) {
            if (!empty($entity[$this->field])) {
                $imageId = $entity[$this->field];
                if (!empty($entity[$this->field][EntityConstants::ID_FIELD_KEY])) {
                    $imageId = $entity[$this->field][EntityConstants::ID_FIELD_KEY];
                }

                if (!is_numeric($imageId)) {
                    throw new Exception(self::NON_NUMERIC_ASSET_ID . " in field " . $this->field);
                }

                $helper = new EntityHelper();
                $image = $this->helper->get((int)$imageId);
                if (!$helper->isValid($image)) {
                    $image = [];
                }

                $image = $this->helper->setOrientation($image);

                $entity[$this->field] = $image;
            }
        }

        return $entity;
    }
    
}