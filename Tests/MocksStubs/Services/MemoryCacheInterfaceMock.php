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
    /**
     * @param $key
     * @param $value
     * @param $ttl
     * @param $index
     *
     * @return true
     */
    public function set($key, $value, $ttl = null, $index = null): bool
    {
        return $key == '__mercurium__testKeyReturnTrue';
    }

    /**
     * @param $key
     * @param $index
     *
     * @return string
     */
    public function get($key, $index = null): string
    {
        return ($key == "__mercurium__testKeyReturnValue") ? "foo" : "";
    }

    /**
     * @param $key
     * @param $index
     *
     * @return bool
     */
    public function delete($key, $index = null): bool
    {
        return $key == '__mercurium__testKeyReturnTrue';
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