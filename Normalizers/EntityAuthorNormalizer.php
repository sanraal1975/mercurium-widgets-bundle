<?php

namespace Comitium5\MercuriumWidgetsBundle\Normalizers;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\MercuriumWidgetsBundle\Abstracts\Interfaces\AbstractEntityNormalizerInterface;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AuthorHelper;
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
     * @param Client $api
     * @param string $field
     * @throws Exception
     */
    public function __construct(Client $api, string $field = "author")
    {
        $this->field = $field;
        $this->helper = new AuthorHelper($api);

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

        $authorId = empty($entity[$this->field]["id"]) ? $entity[$this->field] : $entity[$this->field]["id"];

        if (!is_numeric($authorId)) {
            throw new Exception(self::NON_NUMERIC_AUTHOR_ID . " in field " . $this->field);
        }

        $entity[$this->field] = $this->helper->get((int)$authorId);

        return $entity;
    }
}