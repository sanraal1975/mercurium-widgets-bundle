<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Normalizer\NormalizerInterface;
use Comitium5\MercuriumWidgetsBundle\Constants\BundleConstants;
use Comitium5\MercuriumWidgetsBundle\Normalizers\EntityAssetNormalizer;
use Exception;

/**
 * Class ArticleAssetFieldsNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers\Entities
 */
class ArticleAssetFieldsNormalizer implements NormalizerInterface
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
    private $normalizeVideo;

    /**
     * @var bool
     */
    private $normalizeAudio;

    /**
     * @param Client $api
     * @param bool $normalizeImage
     * @param bool $normalizeVideo
     * @param bool $normalizeAudio
     */
    public function __construct(Client $api, bool $normalizeImage = true, bool $normalizeVideo = false, bool $normalizeAudio = false)
    {
        $this->api = $api;
        $this->normalizeImage = $normalizeImage;
        $this->normalizeVideo = $normalizeVideo;
        $this->normalizeAudio = $normalizeAudio;
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

        if ($this->normalizeImage) {
            $normalizer = new EntityAssetNormalizer($this->api, BundleConstants::IMAGE_FIELD_KEY);
            $entity = $normalizer->normalize($entity);
        }

        if ($this->normalizeVideo) {
            $normalizer = new EntityAssetNormalizer($this->api, BundleConstants::VIDEO_FIELD_KEY);
            $entity = $normalizer->normalize($entity);
        }

        if ($this->normalizeAudio) {
            $normalizer = new EntityAssetNormalizer($this->api, BundleConstants::AUDIO_FIELD_KEY);
            $entity = $normalizer->normalize($entity);
        }

        return $entity;
    }
}