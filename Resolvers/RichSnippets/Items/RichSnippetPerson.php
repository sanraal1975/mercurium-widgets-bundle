<?php

namespace Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items;

use Comitium5\MercuriumWidgetsBundle\Constants\RichSnippetsConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\UtilsHelper;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\RichSnippetPublisherValueObject;
use Exception;

/**
 * Class RichSnippetPerson
 *
 * @package Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items
 */
class RichSnippetPerson
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

        $richSnippetCanonical = new RichSnippetCanonical();
        $richSnippetPublisher = new RichSnippetPublisher($this->valueObject);

        $schema = [
            '@type' => RichSnippetsConstants::TYPE_PERSON,
            "url" => $richSnippetCanonical->getCanonical($entity),
        ];

        if (!empty($entity['fullName'])) {
            $schema["name"] = $entity['fullName'];
        }

        if (!empty($entity['name'])) {
            $schema['givenName'] = $entity["name"];
        }

        if (!empty($entity['surname'])) {
            $schema['familyName'] = $entity['surname'];
        }

        if (!empty($entity['profession'])) {
            $schema['jobTitle'] = $entity['profession'];
        }

        $organization = $richSnippetPublisher->getSchema();
        $organization['@type'] = RichSnippetsConstants::TYPE_NEWS_MEDIA_ORGANIZATION;

        $schema['affiliation'] = $organization;

        if (!empty($entity['tipologies'])) {
            $schema['contactPoint'] = [
                '@type' => RichSnippetsConstants::TYPE_CONTACT_POINT,
                'contactType' => implode(",", $entity['tipologies']),
                "url" => $entity['permalink'],
            ];
            if (!empty($entity['email'])) {
                $schema['contactPoint']['email'] = $entity['email'];
            }
        }

        if (!empty($entity['email'])) {
            $schema['email'] = $entity['email'];
        }

        if (!empty($entity['biography'])) {
            $utilsHelper = new UtilsHelper();
            $schema['description'] = $utilsHelper->cleanHtmlText($entity['biography']);
        }

        if (!empty($entity['socialNetworks'])) {
            $sameAs = [];
            foreach ($entity['socialNetworks'] as $socialNetwork) {
                if (!empty($socialNetwork['url'])) {
                    $sameAs[] = $socialNetwork['url'];
                }
            }
            if (!empty($sameAs)) {
                $schema['sameAs'] = array_values($sameAs);
            }
        }

        if (!empty($entity['asset']['url'])) {
            $richSnippetImage = new RichSnippetImage($this->valueObject);
            $schema['image'] = $richSnippetImage->getSchema($entity['asset']);
        }

        return $schema;
    }
}