<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Services;

use Comitium5\ApiClientBundle\Cache\MemoryCacheInterface;

/**
 * Class MemoryCacheInterfaceMock
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Services
 */
class MemoryCacheInterfaceMock implements MemoryCacheInterface
{
    public function set($key, $value, $ttl = null, $index = null)
    {
        // TODO: Implement set() method.
    }

    public function get($key, $index = null)
    {
        // TODO: Implement get() method.
    }

    public function delete($key, $index = null)
    {
        // TODO: Implement delete() method.
    }

    public function setTTL($key, $ttl)
    {
        // TODO: Implement setTTL() method.
    }

    public function exists($key, $index = null)
    {
        // TODO: Implement exists() method.
    }
}