<?php

namespace Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets;

use Comitium5\MercuriumWidgetsBundle\Constants\RichSnippetsConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\RichSnippetsHelper;
use Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items\RichSnippetPublisher;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\RichSnippetPublisherValueObject;
use Exception;

/**
 * Class OrganizationRichSnippetsResolver
 *
 * @package Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets
 */
class OrganizationRichSnippetsResolver
{
    /**
     * @param RichSnippetPublisherValueObject $richSnippetPublisherValueObject
     *
     * @return string
     * @throws Exception
     */
    public function resolve(RichSnippetPublisherValueObject $richSnippetPublisherValueObject): string
    {
        $helper = new RichSnippetsHelper();

        $richSnippetPublisher = new RichSnippetPublisher($richSnippetPublisherValueObject);
        $schema = $richSnippetPublisher->getSchema();
        $schema = array_merge(["@context" => RichSnippetsConstants::CONTEXT], $schema);

        return $helper->wrap($schema);
    }
}