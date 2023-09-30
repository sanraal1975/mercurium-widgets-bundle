<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Abstracts\Interfaces\AbstractEntityNormalizerInterface;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Exception;

/**
 * Class EntitySponsorNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers
 */
class EntitySponsorNormalizer implements AbstractEntityNormalizerInterface
{
    /**
     * @var Client
     */
    private $api;

    /**
     * @var string
     */
    private $imageFieldKey;

    /**
     * @var string
     */
    private $textFieldKey;

    /**
     * @param Client $api
     * @param string $imageFieldKey
     * @param string $textFieldKey
     */
    public function __construct(Client $api, string $imageFieldKey, string $textFieldKey)
    {
        $this->api = $api;
        $this->imageFieldKey = $imageFieldKey;
        $this->textFieldKey = $textFieldKey;
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

        $normalizer = new EntityImageNormalizer($this->api, $this->imageFieldKey);
        $entity = $normalizer->normalize($entity);

        $hasSponsor = false;

        if (!empty($entity[$this->imageFieldKey])) {
            $hasSponsor = true;
        }

        if (!empty($entity[$this->textFieldKey])) {
            $hasSponsor = true;
        }

        $entity[EntityConstants::HAS_SPONSOR_FIELD_KEY] = $hasSponsor;

        return $entity;
    }


}