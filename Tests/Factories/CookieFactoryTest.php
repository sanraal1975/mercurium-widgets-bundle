<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Factories;

use Comitium5\MercuriumWidgetsBundle\Factories\CookieFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class CookieFactoryTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Factories
 */
class CookieFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testCreateLoginCookie()
    {
        $factory = new CookieFactory();
        $cookie = $factory->createLoginCookie();

        $this->assertInstanceOf(Cookie::class, $cookie);
    }

    /**
     * @return void
     */
    public function testCreateSubscriptionCookie()
    {
        $factory = new CookieFactory();
        $cookie = $factory->createSubscriptionCookie();

        $this->assertInstanceOf(Cookie::class, $cookie);
    }
}