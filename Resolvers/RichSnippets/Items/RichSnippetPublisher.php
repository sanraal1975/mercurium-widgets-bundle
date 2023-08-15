<?php

namespace Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items;

use Comitium5\MercuriumWidgetsBundle\Constants\RichSnippetsConstants;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\RichSnippetPublisherValueObject;
use Exception;

/**
 * Class RichSnippetPublisher
 *
 * @package Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items
 */
class RichSnippetPublisher
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
     * @return array
     * @throws Exception
     */
    public function getSchema(): array
    {
        $socialNetworksUrls = $this->getSocialNetworksUrls(
            $this->valueObject->getSchemaSocialNetworks(),
            $this->valueObject->getProjectSocialNetworks()
        );

        $logo = $this->valueObject->getLogo();
        $image = new RichSnippetImage($this->valueObject);

        return [
            "@type" => RichSnippetsConstants::TYPE_ORGANIZATION,
            "name" => $this->valueObject->getSubSiteName(),
            "url" => $this->valueObject->getSubSiteUrl(),
            "logo" => $image->getSchema($logo),
            "sameAs" => $socialNetworksUrls,
        ];
    }

    /**
     * @param string $socialNetworksNames
     * @param array $socialNetworksDefinitions
     *
     * @return array
     */
    private function getSocialNetworksUrls(string $socialNetworksNames, array $socialNetworksDefinitions): array
    {
        if (empty($socialNetworksNames)) {
            return [];
        }

        if (empty($socialNetworksDefinitions)) {
            return [];
        }

        $socialNetworksUrls = [];
        $socialNetworksNames = explode(",", $socialNetworksNames);

        foreach ($socialNetworksNames as $socialNetwork) {
            $socialNetworkUrl = $socialNetworksDefinitions[$socialNetwork]["url"] ?? "";
            if (empty($socialNetworkUrl)) {
                continue;
            }
            $socialNetworksUrls[] = $socialNetworkUrl;
        }

        return $socialNetworksUrls;
    }
}