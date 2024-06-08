<?php

namespace Comitium5\MercuriumWidgetsBundle\Interfaces;

/**
 * Interface CacheServiceInterface
 *
 * @package Comitium5\MercuriumWidgetsBundle\Interfaces
 */
interface CacheServiceInterface
{
    /**
     * @param string $key
     * @param $value
     * @param int $ttl
     *
     * @return bool
     */
    public function set(string $key, $value, int $ttl): bool;

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function delete(string $key): bool;
}