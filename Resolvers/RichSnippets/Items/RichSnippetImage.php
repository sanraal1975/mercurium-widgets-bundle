<?php

namespace Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items;

use Comitium5\MercuriumWidgetsBundle\Constants\RichSnippetsConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\UtilsHelper;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\RichSnippetPublisherValueObject;
use Exception;

/**
 * Class RichSnippetImage
 *
 * @package Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items
 */
class RichSnippetImage
{
    /**
     * @var RichSnippetPublisherValueObject
     */
    private $valueObject;

    /**
     * @param RichSnippetPublisherValueObject $valueObject
     */
    public function __construct(RichSnippetPublisherValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    /**
     * @param array $entity
     *
     * @return array
     * @throws Exception
     */
    public function getSchema(array $entity): array
    {
        if (empty($entity)) {
            return [];
        }

        $image = [];
        $image["@type"] = RichSnippetsConstants::TYPE_IMAGE;
        $image["url"] = empty($entity["url"]) ? "" : $entity["url"];
        $image["width"] = empty($entity["metadata"]["width"]) ? 0 : $entity["metadata"]["width"];
        $image["height"] = empty($entity["metadata"]["height"]) ? 0 : $entity["metadata"]["height"];
        if (!empty($entity["mimeType"])) {
            $image["encodingFormat"] = $entity["mimeType"];
        }
        if (!empty($entity["title"])) {
            $image["name"] = $entity["title"];
        }
        if (!empty($entity["description"])) {
            $helper = new UtilsHelper();
            $image["description"] = $helper->cleanHtmlText($entity["description"]);
        }
        if (!empty($entity["author"]["permalink"])) {
            $richSnippetPerson = new RichSnippetPerson($this->valueObject);
            $image["author"] = $richSnippetPerson->getSchema($entity["author"]);
        }

        return $image;
    }
}