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
    private $siteName;

    /**
     * @var string
     */
    private $baseUrl;

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
            $this->baseUrl = str_replace("http:", "https:", $this->baseUrl);

            $richSnippets = [
                "@context" => RichSnippetsConstants::CONTEXT,
                "@graph" => [],
            ];

            foreach ($items as $item) {
                $item = [
                    "@id" => $this->baseUrl . " - " . $this->siteName,
                    "@type" => RichSnippetsConstants::TYPE_SITE_NAVIGATION_ELEMENT,
                    "name" => $item['title'],
                    "url" => $this->baseUrl . $item['permalink'],
                ];
                $richSnippets["@graph"][] = $item;
            }

            $helper = new RichSnippetsHelper();

            $richSnippets = $helper->wrap($richSnippets);
        }

        return $richSnippets;
    }
}