<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AuthorHelper;
use Exception;

/**
 * Class EntityAuthorNormalizer
 *
 * @package Comitium5\MercuriumWidgetsBundle\Normalizers
 */
class EntityAuthorNormalizer
{
    const NON_NUMERIC_AUTHOR_ID = "EntityAuthorNormalizer::normalize. non numeric author id.";

    const EMPTY_FIELD = "EntityAuthorNormalizer::validate. field can not be empty.";

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
    public function __construct(Client $api, string $field = "author")
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

        $authorId = $entity[$this->field]['id'] ?? $entity[$this->field];

        if (!is_numeric($authorId)) {
            throw new Exception(self::NON_NUMERIC_AUTHOR_ID . " in field " . $this->field);
        }

        $helper = new AuthorHelper($this->api);

        $entity[$this->field] = $helper->get((int)$authorId);

        return $entity;
    }
}