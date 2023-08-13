<?php

namespace Comitium5\MercuriumWidgetsBundle\Factories;

use Comitium5\MercuriumWidgetsBundle\ValueObjects\RichSnippetPublisherValueObject;

/**
 * Class RichSnippetsFactory
 *
 * @package Comitium5\MercuriumWidgetsBundle\Factories
 */
class RichSnippetsFactory
{
    /**
     * @param string $subSiteName
     * @param string $subSiteUrl
     * @param array $logo
     * @param string $schemaSocialNetworks
     * @param array $projectSocialNetworks
     *
     * @return RichSnippetPublisherValueObject
     */
    public function createRichSnippetPublisherValueObject(
        string $subSiteName,
        string $subSiteUrl,
        array  $logo,
        string $schemaSocialNetworks,
        array  $projectSocialNetworks
    ): RichSnippetPublisherValueObject
    {
        return new RichSnippetPublisherValueObject(
            $subSiteName,
            $subSiteUrl,
            $logo,
            $schemaSocialNetworks,
            $projectSocialNetworks);
    }
}