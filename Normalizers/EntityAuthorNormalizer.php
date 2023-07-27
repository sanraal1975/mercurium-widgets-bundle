<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

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
     * @var AuthorHelper
     */
    private $helper;

    /**
     * @var string
     */
    private $field;

    /**
     * @param AuthorHelper $helper
     * @param string $field
     * @throws Exception
     */
    public function __construct(AuthorHelper $helper, string $field = "author")
    {
        $this->field = $field;
        $this->helper = $helper;

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

        $entity[$this->field] = $this->helper->get((int)$authorId);

        return $entity;
    }
}