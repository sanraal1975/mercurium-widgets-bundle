<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Abstracts\Interfaces\AbstractEntityNormalizerInterface;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AuthorHelper;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\EntityHelper;
use Exception;

/**
 * Class EntityAuthorNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers
 */
class EntityAuthorNormalizer implements AbstractEntityNormalizerInterface
{
    const NON_NUMERIC_AUTHOR_ID = "EntityAuthorNormalizer::normalize. non numeric author id.";

    const EMPTY_FIELD = "EntityAuthorNormalizer::validate. field can not be empty.";

    /**
     * @var AuthorHelper
     */
    private $helper;

    /**
     * @var string
     */
    private $field;

    /**
     * @var EntityNormalizer|null
     */
    private $assetNormalizer;

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
     * @param string $field
     * @param EntityNormalizer|null $assetNormalizer
     * @param bool $normalizeSocialNetworks
     * @param array $bannedSocialNetworks
     * @throws Exception
     */
    public function __construct(
        Client           $api,
        string           $field = EntityConstants::AUTHOR_FIELD_KEY,
        EntityNormalizer $assetNormalizer = null,
        bool             $normalizeSocialNetworks = false,
        array            $bannedSocialNetworks = []
    )
    {
        $this->helper = new AuthorHelper($api);
        $this->field = $field;
        $this->assetNormalizer = $assetNormalizer;
        $this->normalizeSocialNetworks = $normalizeSocialNetworks;
        $this->bannedSocialNetworks = $bannedSocialNetworks;

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
        if (!empty($entity)) {
            if (!empty($entity[$this->field])) {
                $authorId = $entity[$this->field];
                if (!empty($entity[$this->field][EntityConstants::ID_FIELD_KEY])) {
                    $authorId = $entity[$this->field][EntityConstants::ID_FIELD_KEY];
                }

                if (!is_numeric($authorId)) {
                    throw new Exception(self::NON_NUMERIC_AUTHOR_ID . " in field " . $this->field);
                }

                $author = $this->helper->get((int)$authorId);
                $helper = new EntityHelper();
                if (!$helper->isValid($author)) {
                    $author = [];
                } else {
                    if ($this->assetNormalizer != null) {
                        if (!empty($author[EntityConstants::ASSET_FIELD_KEY])) {
                            $author = $this->assetNormalizer->normalize($author);
                        }
                    }

                    if ($this->normalizeSocialNetworks) {
                        $author = $this->getSocialNetworks($author);
                    }
                }
                $entity[$this->field] = $author;
            }
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
        if (!empty($entity[EntityConstants::SOCIAL_NETWORKS_FIELD_KEY])) {
            $entitySocialNetworks = $entity[EntityConstants::SOCIAL_NETWORKS_FIELD_KEY];
            $normalizedSocialNetworks = [];
            $areBannedSocialNetworks = !empty($this->bannedSocialNetworks);

            foreach ($entitySocialNetworks as $socialNetwork) {
                if (!empty($socialNetwork[EntityConstants::URL_FIELD_KEY])) {
                    if ($areBannedSocialNetworks) {
                        if (in_array($socialNetwork[EntityConstants::SOCIAL_NETWORK_FIELD_KEY], $this->bannedSocialNetworks)) {
                            continue;
                        }
                    }
                    $normalizedSocialNetworks[] = $socialNetwork;
                }
            }

            $entity[EntityConstants::SOCIAL_NETWORKS_FIELD_KEY] = $normalizedSocialNetworks;
        }

        return $entity;
    }
}