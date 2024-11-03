<?php

namespace Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets;

use Comitium5\MercuriumWidgetsBundle\Constants\RichSnippetsConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\RichSnippetsHelper;

/**
 * Class SiteNavigationRichSnippetsResolver
 *
 * @package Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets
 */
class SiteNavigationRichSnippetsResolver
{
    /**
     * @var string
     */
    private string $siteName;

    /**
     * @var string
     */
    private string $baseUrl;

    /**
     * @param string $siteName
     * @param string $baseUrl
     */
    public function __construct(string $siteName, string $baseUrl)
    {
        $this->siteName = $siteName;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param array $items
     *
     * @return string
     */
    public function resolve(array $items): string
    {
        $richSnippets = "";

        if (!empty($items)) {
            $this->fixBaseUrl();

            $richSnippets = $this->getBaseStructure();

            foreach ($items as $item) {
                $itemStructure = $this->getItemStructure($item);
                $richSnippets["@graph"][] = $itemStructure;
            }

            $helper = new RichSnippetsHelper();

            $richSnippets = $helper->wrap($richSnippets);
        }

        return $richSnippets;
    }

    /**
     * @return void
     */
    private function fixBaseUrl()
    {
        $this->baseUrl = str_replace("http:", "https:", $this->baseUrl);
    }

    /**
     * @return array
     */
    private function getBaseStructure(): array
    {
        return [
            "@context" => RichSnippetsConstants::CONTEXT,
            "@graph" => [],
        ];
    }

    /**
     * @param array $item
     *
     * @return array
     */
    private function getItemStructure(array $item): array
    {
        return [
            "@id" => $this->baseUrl . " - " . $this->siteName,
            "@type" => RichSnippetsConstants::TYPE_SITE_NAVIGATION_ELEMENT,
            "name" => $item['title'],
            "url" => $this->baseUrl . $item['permalink'],
        ];
    }
}