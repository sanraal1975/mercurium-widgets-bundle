<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Normalizer\NormalizerInterface;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityDynamicFieldsNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityImageNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityNormalizer;
use Exception;

/**
 * Class LiveEventNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers\Entities
 */
class LiveEventNormalizer implements NormalizerInterface
{
    /**
     * @var Client
     */
    private $api;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var string
     */
    private $fieldsKey;

    /**
     * @var string
     */
    private $assetFieldKey;

    /**
     * @var string
     */
    private $localShieldKey;

    /**
     * @var string
     */
    private $visitorShieldKey;

    /**
     * @param Client $api
     * @param array $fields
     * @param string $fieldsKey
     * @param string $assetFieldKey
     * @param string $localShieldKey
     * @param string $visitorShieldKey
     */
    public function __construct(
        Client $api,
        array  $fields,
        string $fieldsKey = EntityConstants::FIELDS_FIELD_KEY,
        string $assetFieldKey = EntityConstants::IMAGE_FIELD_KEY,
        string $localShieldKey = EntityConstants::LOCAL_SHIELD_FIELD_KEY,
        string $visitorShieldKey = EntityConstants::VISITOR_SHIELD_FIELD_KEY
    )
    {
        $this->api = $api;
        $this->fields = $fields;
        $this->fieldsKey = $fieldsKey;
        $this->assetFieldKey = $assetFieldKey;
        $this->localShieldKey = $localShieldKey;
        $this->visitorShieldKey = $visitorShieldKey;
    }

    /**
     * @param array $entity
     *
     * @return array
     * @throws Exception
     */
    public function normalize(array &$entity): array
    {
        $normalizer = new EntityNormalizer(
            [
                new EntityDynamicFieldsNormalizer($this->fields, $this->fieldsKey),
                new EntityImageNormalizer($this->api, $this->assetFieldKey),
                new EntityImageNormalizer($this->api, $this->localShieldKey),
                new EntityImageNormalizer($this->api, $this->visitorShieldKey)
            ]
        );

        $entity = $normalizer->normalize($entity);

        return $entity;
    }
}