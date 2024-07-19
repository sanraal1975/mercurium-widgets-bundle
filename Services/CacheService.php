<?php

namespace Comitium5\MercuriumWidgetsBundle\Services;

use Comitium5\ApiClientBundle\Cache\MemoryCacheInterface;

/**
 * Class CacheService
 *
 * @package Comitium5\MercuriumWidgetsBundle\Services
 */
class CacheService
{
    /**
     * @var
     */
    private $service;

    /**
     * @var string
     */
    private $subSiteAcronym;

    /**
     * @param MemoryCacheInterface $service
     * @param string $subSiteAcronym
     */
    public function __construct(MemoryCacheInterface $service, string $subSiteAcronym)
    {
        $this->service = $service;
        $this->subSiteAcronym = $subSiteAcronym;
    }

    /**
     * @param string $key
     * @param $value
     * @param int $ttl
     *
     * @return bool
     */
    public function set(string $key, $value, int $ttl): bool
    {
        $result = false;

        if (!empty($key)) {
            $cacheKey = $this->buildKey($key);
            $result = $this->service->set($cacheKey, $value, $ttl);
        }

        return $result;
    }

    /**
     * @param string $key
     *
     * @return mixed|string|null
     */
    public function get(string $key)
    {
        $result = "";

        if (!empty($key)) {
            $cacheKey = $this->buildKey($key);
            $result = $this->service->get($cacheKey);
        }

        return $result;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function delete(string $key): bool
    {
        $result = false;
        if (!empty($key)) {
            $cacheKey = $this->buildKey($key);
            $result = $this->service->delete($cacheKey);
        }
        return $result;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function buildKey(string $key): string
    {
        return sprintf(
            '__%s__%s',
            $this->subSiteAcronym,
            $key
        );
    }

}