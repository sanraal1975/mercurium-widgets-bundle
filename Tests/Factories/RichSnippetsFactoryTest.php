<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Factories;

use Comitium5\MercuriumWidgetsBundle\Factories\RichSnippetsFactory;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\RichSnippetPublisherValueObject;
use PHPUnit\Framework\TestCase;

/**
 * Class RichSnippetsFactoryTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Factories
 */
class RichSnippetsFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testCreateRichSnippetPublisherValueObject()
    {
        $factory = new RichSnippetsFactory();

        $valueObject = $factory->createRichSnippetPublisherValueObject(
            "",
            "",
            [],
            "",
            []
        );

        $this->assertInstanceOf(RichSnippetPublisherValueObject::class,$valueObject);
    }
}