<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AssetHelper;
use Exception;

/**
 * Class EntityAssetNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers
 */
class EntityAssetNormalizer
{
    const NON_NUMERIC_ASSET_ID = "EntityAssetNormalizer::normalize. non numeric asset id.";

    const EMPTY_FIELD = "EntityAssetNormalizer::validate. field can not be empty.";

    /**
     * @var Client
     */
    private $api;

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
        $this->api = $api;
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
    public function normalize(array $entity): array
    {
        if (empty($entity)) {
            return $entity;
        }

        if (empty($entity[$this->field])) {
            return $entity;
        }

        $assetId = $entity[$this->field]['id'] ?? $entity[$this->field];

        if (!is_numeric($assetId)) {
            throw new Exception(self::NON_NUMERIC_ASSET_ID . " in field " . $this->field);
        }

        $helper = new AssetHelper($this->api);

        $entity[$this->field] = $helper->get((int)$assetId);

        return $entity;
    }
}