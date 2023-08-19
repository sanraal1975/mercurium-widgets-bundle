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
     * @var RichSnippetPublisherValueObject
     */
    private $valueObject;

    /**
     * @param RichSnippetPublisherValueObject $richSnippetPublisherValueObject
     *
     * @return void
     */
    public function __construct(RichSnippetPublisherValueObject $richSnippetPublisherValueObject)
    {
        $this->valueObject = $richSnippetPublisherValueObject;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function resolve(): string
    {
        $helper = new RichSnippetsHelper();

        $richSnippetPublisher = new RichSnippetPublisher($this->valueObject);
        $schema = $richSnippetPublisher->getSchema();
        $schema = array_merge(["@context" => RichSnippetsConstants::CONTEXT], $schema);

        return $helper->wrap($schema);
    }
}