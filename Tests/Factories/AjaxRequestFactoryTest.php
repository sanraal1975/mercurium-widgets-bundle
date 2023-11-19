<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Factories;

use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Factories\AjaxRequestFactory;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\AjaxRequestValueObject;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class AjaxRequestFactoryTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Factories
 */
class AjaxRequestFactoryTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testCreate()
    {
        $factory = new AjaxRequestFactory();

        $valueObject = $factory->create(
            "dummyAction",
            [EntityConstants::ID_FIELD_KEY => 1]
    );

        $this->assertInstanceOf(AjaxRequestValueObject::class, $valueObject);
    }

}