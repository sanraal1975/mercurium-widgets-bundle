<?php

namespace Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items;

use Comitium5\MercuriumWidgetsBundle\Constants\RichSnippetsConstants;

/**
 * Class RichSnippetFreeAuthor
 *
 * @package Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items
 */
class RichSnippetFreeAuthor
{
    /**
     * @param string $authorNames
     *
     * @return array
     */
    public function getSchema(string $authorNames): array
    {
        if (empty($authorNames)) {
            return [];
        }

        $arrayNames = explode(",", $authorNames);

        $authors = [];
        foreach ($arrayNames as $name) {
            if (!empty($name)) {
                $authors[] = [
                    "@type" => RichSnippetsConstants::TYPE_PERSON,
                    "name" => $name,
                ];
            }
        }

        return $authors;
    }
}