<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Normalizer\NormalizerInterface;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAssetNormalizer;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAuthorNormalizer;
use Exception;

/**
 * Class ArticleAuthorNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers\Entities
 */
class ArticleAuthorNormalizer implements NormalizerInterface
{
    /**
     * @var Client
     */
    private $api;

    /**
     * @var bool
     */
    private $normalizeImage;

    /**
     * @var bool
     */
    private $normalizeSocialNetworks;

    /**
     * @var array
     */
    private $bannedSocialNetworks;

    /**
     * @param Client $api
     * @param bool $normalizeImage
     * @param bool $normalizeSocialNetworks
     * @param array $bannedSocialNetworks
     */
    public function __construct(
        Client $api,
        bool   $normalizeImage = false,
        bool   $normalizeSocialNetworks = false,
        array  $bannedSocialNetworks = []
    )
    {
        $this->api = $api;
        $this->normalizeImage = $normalizeImage;
        $this->normalizeSocialNetworks = $normalizeSocialNetworks;
        $this->bannedSocialNetworks = $bannedSocialNetworks;
    }

    /**
     * @param array $entity
     *
     * @return array
     * @throws Exception
     */
    public function normalize(array &$entity): array
    {
        if (empty($entity)) {
            return [];
        }

        $normalizer = new EntityAuthorNormalizer($this->api);
        $entity = $normalizer->normalize($entity);

        if ($this->normalizeImage) {
            $normalizer = new EntityAssetNormalizer($this->api, BundleConstants::ASSET_FIELD_KEY);
            $entity['author'] = $normalizer->normalize($entity['author']);
        }

        if ($this->normalizeSocialNetworks) {
            $entity['author'] = $this->getSocialNetworks($entity['author']);
        }

        return $entity;
    }

    /**
     * @param array $entity
     *
     * @return array
     */
    private function getSocialNetworks(array $entity): array
    {
        if (empty($entity[BundleConstants::SOCIAL_NETWORKS_FIELD_KEY])) {
            return $entity;
        }

        $entitySocialNetworks = $entity[BundleConstants::SOCIAL_NETWORKS_FIELD_KEY];
        $normalizedSocialNetworks = [];
        $areBannedSocialNetworks = !empty($this->bannedSocialNetworks);

        foreach ($entitySocialNetworks as $socialNetwork) {
            if (empty($socialNetwork['url'])) {
                continue;
            }

            if ($areBannedSocialNetworks) {
                if (in_array($socialNetwork['socialNetwork'], $this->bannedSocialNetworks)) {
                    continue;
                }
            }

            $normalizedSocialNetworks[] = $socialNetwork;
        }

        $entity[BundleConstants::SOCIAL_NETWORKS_FIELD_KEY] = $normalizedSocialNetworks;
        return $entity;
    }
}