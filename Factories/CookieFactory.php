<?php

namespace Comitium5\MercuriumWidgetsBundle\Factories;

use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class CookieFactory
 *
 * @package Comitium5\MercuriumWidgetsBundle\Factories
 */
class CookieFactory
{
    /**
     * @param int $expiration
     *
     * @return Cookie
     */
    public function createLoginCookie(int $expiration = 0): Cookie
    {
        return new Cookie("cs_logged", 1, $expiration, '/', null, false, false);
    }

    /**
     * @param int $expiration
     *
     * @return Cookie
     */
    public function createSubscriptionCookie(int $expiration = 0): Cookie
    {
        return new Cookie("cs_adv", 1, $expiration, '/', null, false, false);
    }
}