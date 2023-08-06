<?php

namespace Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items;

/**
 * Class RichSnippetTitle
 *
 * @package Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items
 */
class RichSnippetTitle
{
    const DEFAULT_FIELD_NAME = "title";

    const MAX_TITLE_LENGTH = PHP_INT_MAX;

    const DEFAULT_COMPLETE_TEXT = "...";

    /**
     * @param array $item
     * @param string $fieldName
     * @param int $length
     * @param string $completeText
     *
     * @return string
     */
    public function getTitle(
        array  $item,
        string $fieldName = self::DEFAULT_FIELD_NAME,
        int    $length = self::MAX_TITLE_LENGTH,
        string $completeText = self::DEFAULT_COMPLETE_TEXT
    ): string
    {
        if (empty($item[$fieldName])) {
            return "";
        }

        $title = trim($item[$fieldName]);

        if (empty($title)) {
            return "";
        }

        if (mb_strlen($title) > $length) {
            $completeTextLength = mb_strlen($completeText);
            $titleLength = $length - $completeTextLength;
            $titleCut = mb_substr($title, 0, $titleLength);
            $trimTitle = trim($titleCut);
            $title = $trimTitle . $completeText;
        }

        return $title;
    }

}