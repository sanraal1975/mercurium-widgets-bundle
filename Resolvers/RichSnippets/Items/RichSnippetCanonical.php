<?php

namespace Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items;

/**
 * Class RichSnippetCanonical
 *
 * @package Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items
 */
class RichSnippetCanonical
{
    /**
     * @param array $entity
     *
     * @return mixed|string
     */
    public function getCanonical(array $entity)
    {
        if (empty($entity)) {
            return "";
        }

        if (!empty($entity['metadata']['canonical'])) {
            return $entity['metadata']['canonical'];
        }

        if (!empty($entity['permalink'])) {
            return $entity['permalink'];
        }

        return "";
    }
}