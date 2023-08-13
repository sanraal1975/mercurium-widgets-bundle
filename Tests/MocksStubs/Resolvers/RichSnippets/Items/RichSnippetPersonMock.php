<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Resolvers\RichSnippets\Items;

use Comitium5\MercuriumWidgetsBundle\Resolvers\RichSnippets\Items\RichSnippetPerson;

class RichSnippetPersonMock extends RichSnippetPerson
{
    /**
     * @param array $entity
     *
     * @return array
     */
    public function getSchema(array $entity): array
    {
        return [];
    }
}